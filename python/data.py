import math

class Data(object):
	data = []
	kelas = ""
	def __init__(self,data):
		self.data = data
		self.kelas = data[len(data)-1]

	def jarak(self,neighbour):
		if len(self.data) != len(neighbour.data):
			return "Error"
		else:
			total = 0
			for x in range(0,len(self.data)-1):
				total += (float(self.data[x]) - float(neighbour.data[x]))**2

			return math.sqrt(total)

	def jarakc(self,centroid):
		if len(self.data) != (len(centroid) + 1):
			return "Error"
		else:
			total = 0
			for x in range(0,len(self.data)-1):
				total += (float(self.data[x]) - float(centroid[x]))**2

			return math.sqrt(total)