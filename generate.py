#!/usr/bin/env python3

import sys
import json
import lzma
from graphenebase.base58 import base58encode, base58decode
from binascii import hexlify, unhexlify

with open(sys.argv[1]) as inv:
    invoice = json.load(inv)

compressed = lzma.compress(bytes(json.dumps(invoice), 'utf-8'), format=lzma.FORMAT_ALONE)
b58 = base58encode(hexlify(compressed).decode('utf-8'))
url = "https://market.gurondex.io/invoice/%s" % b58

print(url)
