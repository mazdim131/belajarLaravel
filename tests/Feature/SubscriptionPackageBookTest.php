<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionPackageBookTest extends TestCase
{
    use RefreshDatabase;

    private SubscriptionPackage $package;

    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $category = BookCategory::create(['name' => 'Romance', 'slug' => 'romance']);

        $this->book = Book::create([
            'cover' => '/storage/covers/test.jpg',
            'title' => 'Setia Kawan',
            'price' => 50000,
            'description' => 'Deskripsi buku',
            'languange' => 'Indonesia',
            'publisher' => 'Erlangga',
            'writer' => 'Tere Liye',
            'release_data' => '2024-01-01',
            'page_of_book' => 320,
            'book_category_id' => $category->id,
        ]);

        $this->package = SubscriptionPackage::create([
            'name' => 'Normal',
            'description' => 'Paket normal',
            'color' => '#000000',
            'prices' => 50000,
        ]);
    }

    public function test_halaman_daftar_buku_paket_tampil_dengan_data_paket(): void
    {
        $response = $this->get(route('admin.subscription-packages.books', $this->package->id));

        $response->assertOk();
        $response->assertViewHas('subscriptionPackage');
        $response->assertViewHas('selectedBookIds', []);
    }

    public function test_endpoint_ajax_datatables_hanya_menampilkan_buku_paket_ini(): void
    {
        $response = $this->getJson(route('admin.subscription-packages.books', $this->package->id), [
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();

        $rows = $response->json('data');
        $this->assertCount(1, $rows);
        $this->assertSame('Setia Kawan', $rows[0]['title']);
        $this->assertSame('Romance', $rows[0]['book_category_id']);
        $this->assertSame(0, (int) $rows[0]['is_selected']);
    }

    public function test_bisa_menyimpan_buku_ke_paket_langganan(): void
    {
        $response = $this->post(route('admin.subscription-packages.books.store'), [
            'subscription_package_id' => $this->package->id,
            'book_id' => [$this->book->id],
            'expired_date' => '2026-12-31',
        ]);

        $response->assertRedirect(route('admin.subscription-packages.books', $this->package->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('subscription_package_books', [
            'book_id' => $this->book->id,
            'subscription_package_id' => $this->package->id,
            'expired_date' => '2026-12-31',
        ]);
    }

    public function test_buku_yang_sudah_tertaut_ditandai_dengan_is_selected(): void
    {
        $this->post(route('admin.subscription-packages.books.store'), [
            'subscription_package_id' => $this->package->id,
            'book_id' => [$this->book->id],
            'expired_date' => '2026-12-31',
        ]);

        $rows = $this->getJson(route('admin.subscription-packages.books', $this->package->id), [
            'X-Requested-With' => 'XMLHttpRequest',
        ])->json('data');
        $this->assertSame(1, (int) $rows[0]['is_selected']);

        $view = $this->get(route('admin.subscription-packages.books', $this->package->id));
        $view->assertViewHas('selectedBookIds', [$this->book->id]);
    }

    public function test_menyimpan_ulang_mengganti_buku_yang_sebelumnya(): void
    {
        $this->post(route('admin.subscription-packages.books.store'), [
            'subscription_package_id' => $this->package->id,
            'book_id' => [$this->book->id],
            'expired_date' => '2026-12-31',
        ]);

        $other = Book::create([
            'cover' => '/storage/covers/test2.jpg',
            'title' => 'Buku Lain',
            'price' => 60000,
            'description' => 'Deskripsi',
            'languange' => 'Indonesia',
            'publisher' => 'Erlangga',
            'writer' => 'Tere Liye',
            'release_data' => '2024-01-01',
            'page_of_book' => 200,
            'book_category_id' => $this->book->book_category_id,
        ]);

        $this->post(route('admin.subscription-packages.books.store'), [
            'subscription_package_id' => $this->package->id,
            'book_id' => [$other->id],
            'expired_date' => '2026-12-31',
        ]);

        $this->assertDatabaseMissing('subscription_package_books', [
            'book_id' => $this->book->id,
            'subscription_package_id' => $this->package->id,
        ]);
        $this->assertDatabaseHas('subscription_package_books', [
            'book_id' => $other->id,
            'subscription_package_id' => $this->package->id,
        ]);
    }

    public function test_validasi_gagal_bila_tidak_ada_buku_yang_dipilih(): void
    {
        $response = $this->post(route('admin.subscription-packages.books.store'), [
            'subscription_package_id' => $this->package->id,
            'book_id' => [],
            'expired_date' => '2026-12-31',
        ]);

        $response->assertSessionHasErrors('book_id');
    }
}
