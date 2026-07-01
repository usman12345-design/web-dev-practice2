<?php

namespace App\Modals;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EmailStatus; // Ensure this matches your Enum namespace
use Symfony\Component\Mime\Address;

class Email extends Model
{
    // 1. Define the table name if it doesn't follow Laravel's plural naming convention
    protected $table = 'emails';

    // 2. Disable default Eloquent timestamps since you handle created_at manually or via MySQL defaults
    public $timestamps = false;

    // 3. Define fillable fields for mass assignment safety
    protected $fillable = ['subject', 'status', 'text_body', 'html_body', 'meta', 'created_at', 'sent_at'];

    // 4. Automatically cast your metadata array and status Enum
    protected $casts = [
        'meta'   => 'array',
        'status' => EmailStatus::class,
    ];

    /**
     * Push a new email into the database queue.
     */
    public function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        // Eloquent handles the json_encode automatically because of the 'array' cast above!
        $meta = [
            'to'   => $to->toString(),
            'from' => $from->toString(),
        ];

        // Create and save the new record using static model instantiation
        static::create([
            'subject'    => $subject,
            'status'     => EmailStatus::Queue, // Pass the Enum instance directly
            'text_body'  => $text,
            'html_body'  => $html,
            'meta'       => $meta,
            'created_at' => date('Y-m-d H:i:s'), // Native PHP timestamp string
        ]);
    }

    /**
     * Get all emails matching a specific status as an array of generic objects.
     */
    public function getEmailByStatus(EmailStatus $status): array
    {
        return static::query()
            ->where('status', $status->value)
            ->get()
            ->map(fn($email) => (object) $email->toArray())
            ->toArray();
    }

    /**
     * Mark a specific queued email as successfully sent.
     */
    public function markEmailSent(int $id): void
    {
        // Find the specific email instance and update it
        $email = static::find($id);

        if ($email) {
            $email->update([
                'status'  => EmailStatus::Sent,
                'sent_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}