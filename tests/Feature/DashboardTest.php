<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin');
        $response->assertViewHasAll([
            'totalAlat',
            'alatTersedia',
            'alatDipinjam',
            'alatRusak',
            'totalUser',
            'totalPeminjaman',
            'chartData',
            'aktivitasTerbaru'
        ]);
    }

    public function test_laboran_can_access_admin_dashboard()
    {
        $laboran = User::factory()->create(['role' => 'laboran']);
        
        $response = $this->actingAs($laboran)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin');
    }

    public function test_regular_user_can_access_user_dashboard()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.user');
        $response->assertViewHasAll([
            'pengajuanAktif',
            'riwayatPeminjaman',
            'alatPopuler',
            'statusBlacklist'
        ]);
    }

    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_shows_correct_statistics()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Create test data
        Alat::factory(5)->create(['status' => 'tersedia', 'stok_tersedia' => 10]);
        Alat::factory(2)->create(['status' => 'rusak', 'stok' => 3]);
        User::factory(3)->create(['role' => 'user']);
        
        $response = $this->actingAs($admin)->get('/dashboard');
        
        $response->assertViewHas('totalAlat', 7); // 5 + 2
        $response->assertViewHas('totalUser', 3); // created users
    }

    public function test_user_dashboard_shows_active_requests()
    {
        $user = User::factory()->create(['role' => 'user']);
        $alat = Alat::factory()->create();
        
        // Create active peminjaman
        Peminjaman::factory()->create([
            'user_id' => $user->id,
            'alat_id' => $alat->id,
            'status_approval' => 'approved',
            'tanggal_kembali' => null
        ]);
        
        // Create completed peminjaman
        Peminjaman::factory()->create([
            'user_id' => $user->id,
            'alat_id' => $alat->id,
            'status_approval' => 'returned',
            'tanggal_kembali' => now()
        ]);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        // pengajuanAktif should have 1 item
        $pengajuanAktif = $response->viewData('pengajuanAktif');
        $this->assertCount(1, $pengajuanAktif);
    }

    public function test_user_dashboard_shows_blacklist_status()
    {
        $user = User::factory()->create(['role' => 'user', 'status_blacklist' => true]);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertViewHas('statusBlacklist', true);
    }

    public function test_chart_data_returns_12_months()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/dashboard');
        
        $chartData = $response->viewData('chartData');
        $this->assertCount(12, $chartData['months']);
        $this->assertCount(12, $chartData['data']);
    }

    public function test_admin_dashboard_shows_recent_activity()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $alat = Alat::factory()->create();
        
        // Create multiple peminjaman
        Peminjaman::factory(5)->create([
            'user_id' => $user->id,
            'alat_id' => $alat->id
        ]);
        
        $response = $this->actingAs($admin)->get('/dashboard');
        
        $aktivitasTerbaru = $response->viewData('aktivitasTerbaru');
        $this->assertCount(5, $aktivitasTerbaru);
    }

    public function test_user_dashboard_shows_popular_tools()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        // Create popular alat
        $alatPopuler = Alat::factory(3)->create();
        foreach ($alatPopuler as $alat) {
            Peminjaman::factory(5)->create(['alat_id' => $alat->id]);
        }
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $alatPopuler = $response->viewData('alatPopuler');
        $this->assertCount(3, $alatPopuler);
    }
}

