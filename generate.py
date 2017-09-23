#!/usr/bin/env python3

import json
import lzma
from graphenebase.base58 import base58encode, base58decode
from binascii import hexlify, unhexlify

invoice = {
    "to": "gurondex-cny",
    "to_label": "GuronDEX",
    "currency": "RUBLE",
    "memo": "Invoice #2234",
    "fee_id": "1.3.1325",
    "line_items": [
        {"label": "T-shirt (M) color:yellow #532", "quantity": 2, "price": "1.00"},
        {"label": "Glasses (aviator)black SKU#3548", "quantity": 1, "price": "0.50"}
    ],
    "note": "Payment for order #533",
    "callback": "https://market.gurondex.io/complete"
}

compressed = lzma.compress(bytes(json.dumps(invoice), 'utf-8'), format=lzma.FORMAT_ALONE)
b58 = base58encode(hexlify(compressed).decode('utf-8'))
url = "https://market.gurondex.io/invoice/%s" % b58

print(url)
