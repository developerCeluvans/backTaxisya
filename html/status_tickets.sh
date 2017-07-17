#!/bin/bash

# variables
MY_DB=appsuser_taxisya
MY_USER=taxisya_user
MY_PASS=AJX9PbHpBECHGD7s

echo "DELETE * FROM ticket_tickets WHERE end_at < NOW()"
UPDATE=$(echo "DELETE * FROM ticket_tickets WHERE end_at < NOW()" | mysql --user=$MY_USER --password=$MY_PASS -N -B $MY_DB)
echo $UPDATE


