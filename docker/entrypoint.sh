#!/bin/bash
set -e

echo "Starting webmin..."
#echo $(which ps) -p 1 -o comm=
$(which service) squid start

#exec $(which squid) -f /etc/squid/squid.conf -NYCd 1 ${EXTRA_ARGS}
exec tail -f /dev/null

## default behaviour is to launch squid
#if [[ -z ${1} ]]; then
#  if [[ ! -d ${SQUID_CACHE_DIR}/00 ]]; then
#    echo "Initializing cache..."
#    $(which squid) -N -f /etc/squid/squid.conf -z
#  fi
##  echo "Starting squid..."
##  exec tail -f /dev/null
#  exec $(which squid) -f /etc/squid/squid.conf -NYCd 1 ${EXTRA_ARGS}
#else
#  exec "$@"
#fi