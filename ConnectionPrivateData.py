class ConnectionPrivateData():
	def setMacSrc(self, mac):
		self._macSrc = mac

	def getMacSrc(self):
		return self._macSrc

	def setMacDst(self,mac):
		self._macDst = mac

	def getMacDst(self):
		return self._macDst

	def setIpSrc(self,ip):
		self._ipSrc = ip

	def getIpSrc(self):
		return self._ipSrc

	def setIpDst(self,ip):
		self._ipDst = ip

	def getIpDst(self):
		return self._ipDst

	def setAck(self,ack):
		self._ack = ack

	def getAck(self):
		return self._ack

	def setSeq(self,seq):
		self._seq = seq

	def getSeq(self):
		return self._seq

	def setSport(self,port):
		self._sport=port

	def getSport(self):
		return self._sport

	def setDport(self,port):
		self._dport=port

	def getDport(self):
		return self._dport

	def setMacs(self,macs):
		elems=macs.split(":")
		mac_src_elems=list()
		mac_dst_elems=list()
		i=0
		while i < 6:
			mac_dst_elems.append(elems[i])
			i=i+1
		self.setMacDst(':'.join(mac_dst_elems))
		while i < 12:
			mac_src_elems.append(elems[i])
			i=i+1
		self.setMacSrc(":".join(mac_src_elems))

	def setDate(self,date):
		self._date = date

	def getDate(self):
		return self._date

	def setTime(self, time):
		self._time=time

	def getTime(self):
		return self._time

	def setDomain(self,domain):
		self._domain=domain

	def getDomain(self):
		return self._domain

	def setPublicIp(self, ip):
		self._publicIp=ip

	def getPublicIp(self):
		return self._publicIp