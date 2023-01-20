<?php
  
use ExcelOperation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;  
class OrderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Order ID',
            'Order Status',
            'Order Date',
            'Order Time',
            'Subtotal (inc tax)',
            'Subtotal (ex tax)',
            'Tax Total',
            'Shipping Cost (inc tax)',
            'Shipping Cost (ex tax)',
            'Handling Cost (inc tax)',
            'Handling Cost (ex tax)',
            'Coupon Details',
            'Order Total (inc tax)',
            'Order Total (ex tax)',
            'Refund Amount',
            'Customer ID',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Ship Method',
            'Payment Method',
            'Store Credit Redeemed',
            'Gift Certificate Amount Redeemed',
            'Gift Certificate Code',
            'Gift Certificate Expiration Date',
            'Total Quantity',
            'Total Shipped',
            'Date Shipped',
            'Order Currency Code',
            'Exchange Rate',
            'Order Notes',
            'Customer Message',
            'Billing Name',
            'Billing First Name',
            'Billing Last Name',
            'Billing Company',
            'Billing Street 1',
            'Billing Street 2',
            'Billing Suburb',
            'Billing State',
            'Billing State Abbreviation',
            'Billing Zip',
            'Billing Country',
            'Billing Suburb + State + Zip',
            'Billing Phone',
            'Billing Email',
            'Merchant-defined Order Status',
            'Shipping Name',
            'Shipping First Name',
            'Shipping Last Name',
            'Shipping Company',
            'Shipping Street 1',
            'Shipping Street 2',
            'Shipping Suburb',
            'Shipping State',
            'Shipping State Abbreviation',
            'Shipping Zip',
            'Shipping Country',
            'Shipping Suburb + State + Zip',
            'Shipping Phone',
            'Shipping Email',
            'Customer Group Name',
            'Product Details',
            '# Unique Products in Order',
            'Combined Product Weight',
            'Todays Date',
            'Peachtree Accounts Receivable Account',
            'Channel ID',
            'Channel Name',
            'Order Source',
            'Transaction ID'
        ];
    }

    public function collection()
    {
        return [
        	(ExcelOperation::all())->withHeadings()
        ];
    }
    
}