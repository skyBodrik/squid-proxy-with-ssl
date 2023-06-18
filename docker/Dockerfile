FROM ubuntu:latest

ENV SQUID_DIR=/usr/local/squid \
    SQUID_USER=proxy

RUN apt-get update
RUN apt-get install build-essential openssl libssl-dev wget -y

WORKDIR /tmp

RUN wget -qO - https://packages.diladele.com/diladele_pub.asc | apt-key add - && \
    echo "deb https://squid413-ubuntu20.diladele.com/ubuntu/ focal main" \
        > /etc/apt/sources.list.d/squid413-ubuntu20.diladele.com.list \
    apt-get update && apt-get install -y \
        squid-common \
        squid-openssl \
        squidclient \
        libecap3 libecap3-dev \
        libdbd-mysql-perl

EXPOSE 3128/tcp
EXPOSE 3129/tcp

#WORKDIR /usr/local/squid/
#
#RUN openssl genrsa -out ca.key 2048 && \
#    chmod 400 ca.key && \
#    openssl req \
#    -new \
#    -x509 \
##    -config ca.cnf \
#    -key ca.key \
#    -out ca.crt \
#    -days 365 \
#    -batch


COPY ./entrypoint.sh /sbin/entrypoint.sh
RUN chmod 755 /sbin/entrypoint.sh

ENTRYPOINT ["/sbin/entrypoint.sh"]