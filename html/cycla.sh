#!/bin/bash

# variables
MY_DB=appsuser_taxisya
MY_USER=taxisya_user
MY_PASS=AJX9PbHpBECHGD7s
LAPSE=$(echo "SELECT int_value FROM configuracion WHERE nombre = 'TIME_LOGOUT_MINUTE'" | mysql --user=$MY_USER --password=$MY_PASS -N -B $MY_DB)

echo "Update drivers set available = 0 where TIMESTAMPDIFF ( MINUTE , updated_at, NOW() ) > $LAPSE AND available = 1"
UPDATE=$(echo "Update drivers set available = 0 where TIMESTAMPDIFF ( MINUTE , updated_at, NOW() ) > $LAPSE AND available = 1
" | mysql --user=$MY_USER --password=$MY_PASS -N -B $MY_DB)

echo $UPDATE

echo $LAPSE
