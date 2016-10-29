from ConnectionPrivateData import *
import psycopg2

DB_NAME="noobs"
USERNAME="postgres"
HOST="localhost"
PASSWORD="kaze123"

TABLE="local_log"

def Connection():
	try:
		_c=psycopg2.connect(database=DB_NAME,user=USERNAME,password=PASSWORD,host=HOST)
		return _c
	except Exception as e:
		print("dfss",e)
def insert(cpd):
	try:
		conn=Connection()
		cur=conn.cursor()
		sql="INSERT INTO "+TABLE+" values('"+cpd.getMacSrc()+"','"+cpd.getMacDst()+"','"+cpd.getIpSrc()+"','"+cpd.getIpDst()+"',"+cpd.getAck()+","+cpd.getSeq()+","+cpd.getSport()+","+cpd.getDport()+",'"+cpd.getDate()+"','"+cpd.getTime()+"',"+str(cpd.getDomain())+",'" + str(cpd.getPublicIp()) + "');"
		cur.execute(sql)
		conn.commit()
	except Exception as e:
		print("error",e)

def check(cpd):
	value=True
	try:
		conn=Connection()
		cur=conn.cursor()
		cur.execute("SELECT * FROM local_log where ip_src='"+cpd.getIpSrc()+"' order by numero")
		vec=cur.fetchall()
		n=len(vec)
		if(n<=0):
			value=False
		else:
			if cpd.getIpSrc()==vec[n-1][2] and cpd.getMacSrc()==vec[n-1][0] :
				value=True
			else:
				value=False
	except Exception as e:
		print("qqqqqqq",e)
		value=True
	return value

def getDomain(domain):
	try:
		conn=Connection()
		cur=conn.cursor()
		cur.execute("SELECT * FROM domaine WHERE nomlogtable='"+domain+"'")
		val=cur.fetchall()
		return val[0]
	except Exception as e:
		return None
