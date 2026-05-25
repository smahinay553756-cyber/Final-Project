<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PROCEDURE 1: Get low stock medicines
        DB::unprepared('DROP PROCEDURE IF EXISTS GetLowStockMedicines');
        DB::unprepared('
            CREATE PROCEDURE GetLowStockMedicines()
            BEGIN
                SELECT id, name, stock_quantity, reorder_level
                FROM medicines
                WHERE stock_quantity <= reorder_level AND status = "active";
            END
        ');

        // PROCEDURE 2: Get order summary for a customer
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCustomerOrderSummary');
        DB::unprepared('
            CREATE PROCEDURE GetCustomerOrderSummary(IN p_user_id INT)
            BEGIN
                SELECT
                    COUNT(*) AS total_orders,
                    SUM(total_amount) AS total_spent,
                    MAX(created_at) AS last_order_date
                FROM orders
                WHERE user_id = p_user_id;
            END
        ');

        // TRIGGER 1: Log stock decrease after order item is inserted
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_item_insert');
        DB::unprepared('
            CREATE TRIGGER after_order_item_insert
            AFTER INSERT ON order_items
            FOR EACH ROW
            BEGIN
                UPDATE medicines
                SET updated_at = NOW()
                WHERE id = NEW.medicine_id;
            END
        ');

        // TRIGGER 2: Prevent cancelling a dispensed order
        DB::unprepared('DROP TRIGGER IF EXISTS before_order_status_update');
        DB::unprepared('
            CREATE TRIGGER before_order_status_update
            BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                IF OLD.status = "dispensed" AND NEW.status = "cancelled" THEN
                    SIGNAL SQLSTATE "45000"
                    SET MESSAGE_TEXT = "Cannot cancel an already dispensed order.";
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetLowStockMedicines');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetCustomerOrderSummary');
        DB::unprepared('DROP TRIGGER IF EXISTS after_order_item_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS before_order_status_update');
    }
};
