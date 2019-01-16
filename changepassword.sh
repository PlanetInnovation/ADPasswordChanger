#!/bin/bash
(echo $2; echo $3; echo $4) | smbpasswd -r YourADServerName -U $1 2>&1
