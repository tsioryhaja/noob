import os
import sys
import time
import glob
import datetime
import PersistenceDB


MAC_PATH = "/usr/omnis/MAC/"
LOG_PATH = "/var/omnis/DB_CONNLOG/"

DOMAIN = " "
date = " "
temps = " "
action = " "
status = " "
inf = " "
proto = " "
src = " "
dst = " "
sport = " "
dport = " "

_ip = getPublicIP()

target_port = -1
nb_port = 0

charge = 0
date_debut = None
date_final = None

DUREE = 60

SEUIL_DE_CHARGE

def TraiterFileLog(filename, domain, con, HAS_TIME=True):
    f = open(filename, "r",-1)
    LINE_INDEX = 0
    LINELOG = "LINE"
    LINELOG = f.readline().decode(sys.getfilesystemencoding())
    while LINELOG.__len__() > 3:
        LINE_OK = True
        LINE_INDEX = LINE_INDEX + 1
        print("\n"+LINELOG)
        if HAS_TIME:
            ttime = LINELOG[1:18]
            date_time = str(datetime.datetime.fromtimestamp(float(ttime)))
            date = date_time[:10]
            temps = date_time[11:19]
            LINELOG = LINELOG[20:]
        dicts = LINELOG.split(" ")
        i = 0
        status = "N/A"
        sport = "N/A"
        dport = "N/A"
        inf = "N/A"

        for d in dicts:
            if len(d) > 0:
                i = i + 1
                if i == 1:
                    action = d
                    continue
                elif i == 2:
                    proto = d
                    continue
                elif i == 3:
                    continue
                elif i == 4 and not d.__contains__("="):
                    continue
                elif i == 5 and not d.__contains__("="):
                    if proto == "tcp":
                        status = d
                        continue
                elif d.__contains__("="):
                    sub_d = d.split("=");
                    if sub_d[0] == "src":
                        src = sub_d[1]
                        continue
                    if sub_d[0] == "dst":
                        dst = sub_d[1]
                        continue
                    if sub_d[0] == "sport":
                        sport = sub_d[1]
                        continue
                    if sub_d[0] == "dport":
                        dport = sub_d[1]
                        continue
                elif d.__contains__("[") and d.__contains__("]"):
                    inf = d
                    if d == "[UNREPLIED]":
                        src,dst = dst,src
                        sport,dport = dport,sport
                    continue
                else:
                    print("Champs inconnu : "+ d)
        try:
            if src == "127.0.0.1" or dst == "127.0.0.1":
                LINE_OK = False
            if action == "[UPDATE]":
                LINE_OK == False
            if int(sport) == 53 and proto == "udp":
                LINE_OK = False
        except Exception as e:
            print ("Erreur de filtrage...")

        sys.stdout.write("\ndate=" + date)
        sys.stdout.write(" time=" + temps)
        sys.stdout.write(" action=" + action)
        sys.stdout.write(" proto=" + proto)
        sys.stdout.write(" status=" + status)
        print ("\n src=" + src + ":" + sport)
        print (" dst=" + dst + ":" + dport)
        print (" info=" + inf)
        LINELOG = f.readline().decode(sys.getfilesystemencoding())

        if LINE_OK:
        	if date_debut == None:
        		_date = date.split("-")
        		_time = temps.split(":")
        		date_debut = datetime(_date[0],_date[1],_date[2],_time[0],_time[1])
        	else:
        		_date_f = date.split("-")
        		_time_f = temps.split(":")
        		date_final = datetime(_date_f[0],_date_f[1],_date_f[2],_time_f[0],_time_f[1])
            client = PersistenceDB.ConnexionPU()
            client.setDate(date)
            client.setTime(temps)
            client.setAction(action)
            client.setProtocol(proto)
            client.setStatus(status)
            client.setIpDest(src)
            client.setIpsource(dst)
            client.setDstPort(sport)
            client.setSrcPort(dport)
            client.setInfo(inf)
            PersistenceDB.inserer(client,domain,con)
            charge = charge + 1
            _diff=date_final-date_debut
            if _diff.seconds > DUREE:
            	charge = 0
            	date_final = None
            	date_debut = None
    f.close()
    return True  # end TraiterFileLog()

    ######################### MAIN #############################

os.system("python "+MAC_PATH+"MacMain.py &")

while True:
    files = glob.glob(LOG_PATH + "log_track_*")
    indexLogFile = 1
    nbLogfile = files.__len__()
    con = PersistenceDB.connexionDB()
    if con == False:
        time.sleep(3)
        continue
    for f in files:
        DOMAIN = str(f).split("_")[3]
        print("\n DOMAINE: "+DOMAIN)
        if os.path.isfile(os.path.join(f)):
            print("[" + str(indexLogFile) + "/" + str(nbLogfile) + "]" + "================================================ " + f)
            if TraiterFileLog(f,DOMAIN,con):
                os.remove(f)
                print ("========================================== End of "+f)
        indexLogFile += 1
    time.sleep(3)
    print ("[FileToDB] .")

def getPublicIP():
    try:
        ip = load(urlopen('https://api.ipify.org/?format=json'))['ip']
        return ip
    except Exception as e:
	return DEFAULT_IP