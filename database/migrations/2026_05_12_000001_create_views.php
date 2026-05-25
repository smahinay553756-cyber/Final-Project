<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // VIEW 1: Sales summary per order with customer name
        DB::unprepared('DROP VIEW IF EXISTS view_order_summary');
        DB::unprepared('
            CREATE VIEW view_order_summary AS
            SELECT
                o.id,
                o.order_number,
                CASE WHEN o.is_walkin = 1 THEN o.walkin_name ELSE u.name END AS customer_name,
                o.total_amount,
                o.payment_method,
                o.payment_status,
                o.status,
                o.is_walkin,
                o.created_at
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
        ');

        // VIEW 2: Low stock medicines
        DB::unprepared('DROP VIEW IF EXISTS view_low_stock_medicines');
        DB::unprepared('
            CREATE VIEW view_low_stock_medicines AS
            SELECT
                id,
                name,
                generic_name,
                brand,
                category,
                dosage_form,
                dosage_strength,
                dosage_unit,
                stock_quantity,
                reorder_level,
                expiry_date,
                status
            FROM medicines
            WHERE stock_quantity <= reorder_level AND status = "active"
        ');

        // VIEW 3: Stock log history with staff and admin names
        DB::unprepared('DROP VIEW IF EXISTS view_stock_log_history');
        DB::unprepared('
            CREATE VIEW view_stock_log_history AS
            SELECT
                sl.id,
                m.name AS medicine_name,
                m.dosage_strength,
                m.dosage_unit,
                s.name AS staff_name,
                a.name AS approved_by_name,
                sl.type,
                sl.quantity,
                sl.stock_before,
                sl.stock_after,
                sl.status,
                sl.approved_at,
                sl.created_at
            FROM stock_logs sl
            JOIN medicines m ON m.id = sl.medicine_id
            JOIN users s ON s.id = sl.staff_id
            LEFT JOIN users a ON a.id = sl.approved_by
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS view_order_summary');
        DB::unprepared('DROP VIEW IF EXISTS view_low_stock_medicines');
        DB::unprepared('DROP VIEW IF EXISTS view_stock_log_history');
    }
};
