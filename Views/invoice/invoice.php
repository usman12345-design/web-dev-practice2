<h2>Paid Invoices Dashboard</h2>

<?php if (empty($invoices)): ?>
    <p>No paid invoices found in the system ledger storage matching parameters.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Invoice ID</th>
            <th>Invoice Number</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><strong>#<?= htmlspecialchars($invoice->id) ?></strong></td>
                <td><?= htmlspecialchars($invoice->invoice_number) ?></td>
                <td>$<?= htmlspecialchars(number_format($invoice->amount, 2)) ?></td>
                <td>
                            <span class="status-badge">
                                <?= htmlspecialchars($invoice->status->toString()) ?>
                            </span>
                </td>
                <td><?= htmlspecialchars($invoice->created_at) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>