<x-mail::message>

    Dear {{ $customer }},

    We are pleased to inform you that your payment has been successfully processed.

    Details of your transaction are as follows:

    Payment Amount: {{ $amount }}
    Date of Payment: {{ $date_of_payment }}
    Transaction ID: {{ $transaction_id }}
    Your payment has been applied to your account, and no further action is required at this time. If you have any
    questions or need further assistance, please do not hesitate to contact our customer service team.

    Thank you for your prompt payment.

</x-mail::message>
