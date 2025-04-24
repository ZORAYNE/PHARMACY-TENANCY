<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;
    public $tenantLink;

    /**
     * Create a new message instance.
     *
     * @param Tenant $tenant
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
        $this->tenantLink = url('/tenants/' . $tenant->id . '/dashboard'); // adjust if needed
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('You’ve been approved — your site is ready!')
                    ->view('emails.tenant_approved')
                    ->with([
                        'tenantName' => $this->tenant->name,
                        'tenantLink' => $this->tenantLink,
                    ]);
    }
}
