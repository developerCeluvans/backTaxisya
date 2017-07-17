#!/bin/bash

# variables
MY_DB=appsuser_taxisya
MY_USER=taxisya_user
MY_PASS=AJX9PbHpBECHGD7s

echo "UPDATE services SET status_id = 5 WHERE TIMESTAMPDIFF ( MINUTE , updated_at, NOW() ) > 50 AND status_id IN (2,4)"
UPDATE=$(echo "UPDATE services SET status_id = 5 WHERE TIMESTAMPDIFF ( MINUTE , updated_at, NOW() ) > 50 AND status_id IN (2,4)" | mysql --user=$MY_USER --password=$MY_PASS -N -B $MY_DB)
echo $UPDATE


