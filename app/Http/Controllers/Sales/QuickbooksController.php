<?php

namespace App\Http\Controllers\Sales;

use Artisaninweb\SoapWrapper\SoapWrapper;

class QuickBooksController extends Controller
{
    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function handleWebConnector()
    {
        $this->soapWrapper->add('QuickBooks', function ($service) {
            $service
                ->wsdl('https://developer.intuit.com/.../qbwebconnectorsvc.wsdl') // QB WSDL
                ->trace(true);
        });

        return response($this->soapWrapper->call('QuickBooks.serverVersion'));
    }

public function generateInvoiceQBXML(array $invoiceData)
{
    $lines = '';
    foreach ($invoiceData['items'] as $item) {
        $lines .= '
            <InvoiceLineAdd>
                <ItemRef>
                    <FullName>' . htmlspecialchars($item['name']) . '</FullName>
                </ItemRef>
                <Quantity>' . $item['quantity'] . '</Quantity>
                <Rate>' . $item['rate'] . '</Rate>
            </InvoiceLineAdd>';
    }

    return '<?xml version="1.0"?>
        <?qbxml version="13.0"?>
        <QBXML>
            <QBXMLMsgsRq onError="stopOnError">
                <InvoiceAddRq>
                    <InvoiceAdd>
                        <CustomerRef>
                            <FullName>' . htmlspecialchars($invoiceData['customer_name']) . '</FullName>
                        </CustomerRef>
                        <TxnDate>' . $invoiceData['date'] . '</TxnDate>
                        <RefNumber>' . $invoiceData['invoice_number'] . '</RefNumber>
                        ' . $lines . '
                    </InvoiceAdd>
                </InvoiceAddRq>
            </QBXMLMsgsRq>
        </QBXML>';
}
}

