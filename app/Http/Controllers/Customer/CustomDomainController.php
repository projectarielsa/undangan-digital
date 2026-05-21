<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomDomain;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomDomainController extends Controller
{
    /**
     * Show custom domain settings
     */
    public function show(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        // Check if user has custom domain feature
        if (!$invitation->hasCustomDomainFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur Custom Domain hanya tersedia untuk paket Exclusive. Silakan upgrade paket Anda.');
        }

        $customDomain = $invitation->customDomain;

        return view('customer.invitations.custom-domain', compact('invitation', 'customDomain'));
    }

    /**
     * Store new custom domain
     */
    public function store(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        if (!$invitation->hasCustomDomainFeature()) {
            return back()->with('error', 'Fitur Custom Domain tidak tersedia untuk paket Anda.');
        }

        // Check if already has a domain
        if ($invitation->customDomain) {
            return back()->with('error', 'Undangan ini sudah memiliki custom domain. Hapus terlebih dahulu untuk mengganti.');
        }

        $validated = $request->validate([
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
                'unique:custom_domains,domain',
            ],
        ], [
            'domain.required' => 'Domain wajib diisi.',
            'domain.regex' => 'Format domain tidak valid. Contoh: undangan.domain.com',
            'domain.unique' => 'Domain ini sudah digunakan.',
        ]);

        $customDomain = $invitation->customDomain()->create([
            'domain' => strtolower($validated['domain']),
            'status' => 'pending',
        ]);

        // Generate DNS instructions
        $customDomain->update([
            'dns_instructions' => $customDomain->generateDnsInstructions(),
        ]);

        return back()->with('success', 'Domain berhasil ditambahkan. Silakan ikuti instruksi DNS di bawah.');
    }

    /**
     * Verify domain DNS
     */
    public function verify(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $customDomain = $invitation->customDomain;

        if (!$customDomain) {
            return back()->with('error', 'Custom domain tidak ditemukan.');
        }

        // Check DNS
        $isVerified = $this->checkDns($customDomain->domain);

        if ($isVerified) {
            $customDomain->markAsActive();
            return back()->with('success', 'Domain berhasil diverifikasi dan aktif!');
        }

        $customDomain->markAsFailed();
        return back()->with('error', 'Verifikasi DNS gagal. Pastikan record CNAME sudah benar dan tunggu propagasi DNS (bisa memakan waktu hingga 48 jam).');
    }

    /**
     * Delete custom domain
     */
    public function destroy(Request $request, Invitation $invitation)
    {
        $this->authorize('update', $invitation);

        $customDomain = $invitation->customDomain;

        if (!$customDomain) {
            return back()->with('error', 'Custom domain tidak ditemukan.');
        }

        $customDomain->delete();

        return back()->with('success', 'Custom domain berhasil dihapus.');
    }

    /**
     * Check DNS records
     */
    private function checkDns(string $domain): bool
    {
        $appDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        try {
            $records = dns_get_record($domain, DNS_CNAME);
            
            foreach ($records as $record) {
                if (isset($record['target']) && $record['target'] === $appDomain) {
                    return true;
                }
            }

            // Also check if domain resolves to our IP (A record)
            $ip = gethostbyname($domain);
            $ourIp = gethostbyname($appDomain);
            
            if ($ip === $ourIp && $ip !== $domain) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
