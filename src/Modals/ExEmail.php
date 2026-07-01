<?php
namespace App\Modals;

use App\Modal;
use PDO;
use Symfony\Component\Mime\Address;
use App\Enums\EmailStatus;


class ExEmail extends Modal
{
    public function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        // 1. Initialize the Query Builder
        $queryBuilder = $this->db->createQueryBuilder();

// 2. Format your meta array data
        $meta['to']   = $to->toString();
        $meta['from'] = $from->toString();

// 3. Build and execute the fluent insert operation
        $queryBuilder
            ->insert('emails')
            ->values([
                'subject'   => '?',
                'status'    => '?',
                'text_body' => '?',
                'html_body' => '?',
                'meta'      => '?',
                'created_at'=> 'NOW()' // Raw SQL functions work right inside the values map
            ])
            ->setParameters([
                $subject,
                EmailStatus::Queue->value,
                $text,
                $html,
                json_encode($meta)
            ])
            ->executeQuery(); // Triggers the safe insert query execution
    }

    public function getEmailByStatus(EmailStatus $status): array
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $stmt = $queryBuilder->select('*')->from('emails')->where('status = ?')->setParameters([$status->value])->executeQuery();
        $rows = $stmt->fetchAllAssociative();
        return array_map(fn($row) => (object) $row, $rows);
    }

    public function markEmailSent(int $id): void
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->update('emails')
            ->set('status', ':status')
            ->set('sent_at', 'NOW()')
            ->where('id = :id')
            ->setParameters(['status'=> EmailStatus::Sent->value,
                'id'=> $id])
            ->executeQuery();
    }
}