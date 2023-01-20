<?php

namespace App\Imports;

use App\ExcelOperation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class LibraryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {   
            ExcelOperation::truncate();
    }
    public function model(array $row)
    {
      ExcelOperation::updateOrCreate(
            ['Order_ID' => $row['order_id']],
            ['Order_Status' => $row['order_status'],'Order_Date' => $row['order_date'],'Order_Time' => $row['order_time'],'Subtotal_inc_tax' => $row['subtotal_inc_tax'],'Subtotal_ex_tax' => $row['subtotal_ex_tax'],'Tax_Total' => $row['tax_total'],'Shipping_Cost_inc_tax' => $row['shipping_cost_inc_tax'],'Shipping_Cost_ex_tax' => $row['shipping_cost_ex_tax'],'Handling_Cost_inc_tax' => $row['handling_cost_inc_tax'],'Handling_Cost_ex_tax' => $row['handling_cost_ex_tax'],'Coupon_Details' => $row['coupon_details'],'Order_Total_inc_tax' => $row['order_total_inc_tax'],'Order_Total_ex_tax' => $row['order_total_ex_tax'],'Refund_Amount' => $row['refund_amount'],'Customer_ID' => $row['customer_id'],'Customer_Name' => $row['customer_name'],'Customer_Email' => $row['customer_email'],'Customer_Phone' => $row['customer_phone'],'Ship_Method' => $row['ship_method'],'Payment_Method' => $row['payment_method'],'Store_Credit_Redeemed' => $row['store_credit_redeemed'],'Gift_Certificate_Amount_Redeemed' => $row['gift_certificate_amount_redeemed'],'Gift_Certificate_Code' => $row['gift_certificate_code'],'Gift_Certificate_Expiration_Date' => $row['gift_certificate_expiration_date'],'Total_Quantity' => $row['total_quantity'],'Total_Shipped' => $row['total_shipped'],'Date_Shipped' => $row['date_shipped'],'Order_Currency_Code' => $row['order_currency_code'],'Exchange_Rate' => $row['exchange_rate'],'Order_Notes' => $row['order_notes'],'Customer_Message' => $row['customer_message'],'Billing_Name' => $row['billing_name'],'Billing_First_Name' => $row['billing_first_name'],'Billing_Last_Name' => $row['billing_last_name'],'Billing_Company' => $row['billing_company'],'Billing_Street_1' => $row['billing_street_1'],'Billing_Street_2' => $row['billing_street_2'],'Billing_Suburb' => $row['billing_suburb'],'Billing_State' => $row['billing_state'],'Billing_State_Abbreviation' => $row['billing_state_abbreviation'],'Billing_Zip' => $row['billing_zip'],'Billing_Country' => $row['billing_country'],'Billing_Suburb_State_Zip' => $row['billing_suburb_state_zip'],'Billing_Phone' => $row['billing_phone'],'Billing_Email' => $row['billing_email'],'Merchantdefined_Order_Status' => $row['merchant_defined_order_status'],'Shipping_Name' => $row['shipping_name'],'Shipping_First_Name' => $row['shipping_first_name'],'Shipping_Last_Name' => $row['shipping_last_name'],'Shipping_Company' => $row['shipping_company'],'Shipping_Street_1' => $row['shipping_street_1'],'Shipping_Street_2' => $row['shipping_street_2'],'Shipping_Suburb' => $row['shipping_suburb'],'Shipping_State' => $row['shipping_state'],'Shipping_State_Abbreviation' => $row['shipping_state_abbreviation'],'Shipping_Zip' => $row['shipping_zip'],'Shipping_Country' => $row['shipping_country'],'Shipping_Suburb_State_Zip' => $row['shipping_suburb_state_zip'],'Shipping_Phone' => $row['shipping_phone'],'Shipping_Email' => $row['shipping_email'],'Customer_Group_Name' => $row['customer_group_name'],'Product_Details' => $row['product_details'],'_Unique_Products_in_Order' => $row['unique_products_in_order'],'Combined_Product_Weight' => $row['combined_product_weight'],'Todays_Date' => $row['todays_date'],'Peachtree_Accounts_Receivable_Account' => $row['peachtree_accounts_receivable_account'],'Channel_ID' => $row['channel_id'],'Channel_Name' => $row['channel_name'],'Order_Source' => $row['order_source'],'Transaction_ID' => $row['transaction_id']]
        );
   
    }
}
