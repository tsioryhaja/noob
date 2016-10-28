import os
import sys
import time
import subprocess
import datetime


TIME_SLEEP = 10
NB_LINE = 0
MAX_LINE = 10
LOG_PATH = "/var/omnis/CONNLOG/"
RUN_PATH = "/usr/omnis/"
DOMAIN = "wiximg"

need_config = True

if need_config :
    os.system("modprobe ip_conntrack")
    os.system("modprobe nf_conntrack")
    os.system("iptables -t filter -F")
    os.system("iptables -t nat -F")
    os.system("iptables -A POSTROUTING -t nat -o eth1 -j MASQUERADE")
    os.system("iptables -A FORWARD -t filter -p tcp -m conntrack --ctstate ESTABLISHED -j NFLOG")
    os.system("echo 1 > /proc/sys/net/ipv4/ip_forward")
    os.system("mkdir /var/omnis/CONNLOG")
    os.system("chmod 777 -R /var/omnis/CONNLOG")
    os.system("echo 1 > /proc/sys/net/ipv4/ip_forward")
    os.system("python "+RUN_PATH+"SendMac.py")


def principal():
    now = datetime.datetime.now()
    FILE_NAME = "log_track_"+DOMAIN+"_"+str(now.year) +"-" + str(now.month) +"-"+ str(now.day) +"_"+ str(now.hour) +"h"+ str(now.minute)
    com_start = "/usr/sbin/conntrack -E -o timestamp > " + LOG_PATH + FILE_NAME
    pipe = subprocess.Popen(com_start, shell=True)
    print("Creation de nouveau fichier:" + FILE_NAME)
    i = 0
    while True:
        time.sleep(TIME_SLEEP)
        com_line = "wc -l " + LOG_PATH + FILE_NAME
        proc = os.popen(com_line)
        nbLineStr = proc.read().split(" ")[0]
        try:
            NB_LINE = int(nbLineStr)
        except Exception as e:
	    print("Nb ligne non entier : "+nbLineStr)
            continue
        print("[CONNLOG] : " + str(NB_LINE))
        if NB_LINE > MAX_LINE :
            break
    os.system("killall conntrack")


while True:
    principal()
