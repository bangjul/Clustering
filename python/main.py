from data import Data as Data
from operator import itemgetter
from random import randint
import xlrd, sys, math, json
from copy import deepcopy

def readFile(filename,datasetlist = [], nilaimaxdata = []):
	dataset = xlrd.open_workbook(filename)
	dataset = dataset.sheet_by_name('Sheet1')
	start_row = 0

	for x in range(start_row,dataset.nrows):
		listdata = []
		for y in range(dataset.ncols):
			listdata.append(dataset.cell(x,y).value)
			if y < dataset.ncols - 1:
				if x == 0:
					nilaimaxdata.append(float(dataset.cell(x,y).value))
				else:
					if nilaimaxdata[y] < float(dataset.cell(x,y).value):
						nilaimaxdata[y] = float(dataset.cell(x,y).value)
		data = Data(data = listdata)
		datasetlist.append(data)

def jarakkmeans(centroidlama, centroidbaru):
	total = 0
	for x in range(0,len(centroidlama)-1):
		total += (float(centroidlama[x]) - float(centroidbaru[x]))**2

	return math.sqrt(total)


def kmeans(datasetlist, jumlahcluster, nilaimaxdata):
	panjangdimensi = len(nilaimaxdata)
	centroid = []
	datapemilihcluster=[]
	i = 1

	while True:
		centroidtmp = []
		datasetlisttmp = deepcopy(datasetlist)

		if len(centroid) == 0:
			for x in range(jumlahcluster):
				centroidtunggal = []
				for y in range(panjangdimensi):
					centroidtunggal.append(randint(0,int(nilaimaxdata[y])+1))
				centroid.append(centroidtunggal)
			print("Centroid hasil random:")
			for x in range(len(centroid)):
				print("koordinat centroid ke " + str(x+1) + " = " + str(centroid[x]))
		else:
			sama = 0;
			for x in range(len(centroid)):
				if len(newcentroid[x]) == 0:
					centroidtmp.append(centroid[x])
					sama += 1
				else:
					if jarakkmeans(centroidlama = centroid[x], centroidbaru = newcentroid[x]) != 0:
						centroidtmp.append(newcentroid[x])
					else:
						centroidtmp.append(centroid[x])
						sama += 1

			if sama == len(centroid):
				break
	
			centroid = deepcopy(centroidtmp)

		for x in range(len(datasetlisttmp)):
			jarak = []
			for y in range(0,len(centroid)):
				jarak.append([y, datasetlisttmp[x].jarakc(centroid[y])])
			jarak.sort(key=itemgetter(1))

			datasetlisttmp[x] = [datasetlisttmp[x],jarak[0]]
		
		datapemilihcluster = []
		for x in range(jumlahcluster):
			datapemilihpercluster = []
			for y in range(len(datasetlisttmp)):
				if datasetlisttmp[y][1][0] == x:
					datapemilihpercluster.append(datasetlisttmp[y])
			datapemilihcluster.append(datapemilihpercluster)

		newcentroid = []
		for x in range(len(datapemilihcluster)):
			newcentroidtmp = []
			for z in range(0,panjangdimensi):
				total = 0
				if len(datapemilihcluster[x]) == 0:
					continue
				else:
					for y in range(len(datapemilihcluster[x])):
						total += datapemilihcluster[x][y][0].data[z]
					newcentroidtmp.append(total/len(datapemilihcluster[x]))
			newcentroid.append(newcentroidtmp)

		print("Iterasi ke " + str(i))
		for x in range(len(newcentroid)):
			print("koordinat centroid ke " + str(x+1) + " = " + str(newcentroid[x]))
			print("Jumlah pemilih = " + str(len(datapemilihcluster[x])))
		i += 1
		print("")
		print("")

def createdbjarak(datajarak,datasetlist):
	for x in range(len(datasetlist)-1):
		datajarak.append([])

	for x in range(len(datasetlist)):
		for y in range(x+1,len(datasetlist)):
			datajarak[x].append(datasetlist[x].jarak(datasetlist[y]))

def getjarak(datajarak,indexc1, indexc2):
	if indexc1 > indexc2:
		x = indexc2
		y = indexc1
	else:
		x = indexc1
		y = indexc2

	return datajarak[x][y-x-1]


def singlelinkage(cluster1, cluster2, datajarak, idclust1, idclust2):
	jarak = []
	for x in range(len(cluster1)):
		for y in range(len(cluster2)):
			jarak.append([idclust1,idclust2,getjarak(datajarak=datajarak, indexc1 = cluster1[x][0], indexc2 = cluster2[y][0])])

	jarak.sort(key=itemgetter(2))
	return jarak[0]

def completelinkage(cluster1, cluster2, datajarak, idclust1, idclust2):
	jarak = []
	for x in range(len(cluster1)):
		for y in range(len(cluster2)):
			jarak.append([idclust1,idclust2,getjarak(datajarak=datajarak, indexc1 = cluster1[x][0], indexc2 = cluster2[y][0])])

	jarak.sort(key=itemgetter(2),reverse=True)
	return jarak[0]

def averagelinkage(cluster1, cluster2, datajarak, idclust1, idclust2):
	jarak = 0
	for x in range(len(cluster1)):
		for y in range(len(cluster2)):
			jarak+=getjarak(datajarak=datajarak, indexc1 = cluster1[x][0], indexc2 = cluster2[y][0])

	return [idclust1,idclust2,jarak/(len(cluster1) + len(cluster2))]

def meankor(cluster, panjangdimensi):
	centroidtmp = []
	for x in range(panjangdimensi):
		totaltmp = 0
		for y in range(len(cluster)):
			totaltmp +=  cluster[y][1].data[x]
		if len(cluster) > 0:
			centroidtmp.append(totaltmp/len(cluster))
		else:
			centroidtmp.append(0)
	return centroidtmp

def centroidlinkage(cluster1, cluster2, datajarak, idclust1, idclust2,panjangdimensi):
	korclust1 = meankor(cluster = cluster1, panjangdimensi = panjangdimensi)
	korclust2 = meankor(cluster = cluster2, panjangdimensi = panjangdimensi)
	
	return [idclust1,idclust2,jarakkmeans(centroidlama = korclust1, centroidbaru = korclust2)]
	


def linkage(datasetlist, jumlahcluster, panjangdimensi, metodepenghitunganjarak):
	datasetlisttmp = deepcopy(datasetlist)
	cluster = []

	datajarak = []

	createdbjarak(datajarak = datajarak, datasetlist=datasetlist)

	for x in range(len(datasetlisttmp)):
		cluster.append([[x,datasetlisttmp[x]]])

	i = 0
	while len(cluster) != jumlahcluster:
		jarak = []
		for x in range(len(cluster)):
			for y in range(x+1,len(cluster)):
				if metodepenghitunganjarak == 1:
					jarak.append(singlelinkage(cluster1 = cluster[x],cluster2=cluster[y],datajarak=datajarak, idclust1 = x, idclust2 = y))
				elif metodepenghitunganjarak == 2:
					jarak.append(centroidlinkage(cluster1 = cluster[x],cluster2=cluster[y],datajarak=datajarak, idclust1 = x, idclust2 = y, panjangdimensi = panjangdimensi))
				elif metodepenghitunganjarak == 3:
					jarak.append(completelinkage(cluster1 = cluster[x],cluster2=cluster[y],datajarak=datajarak, idclust1 = x, idclust2 = y))
				elif metodepenghitunganjarak == 4:
					jarak.append(averagelinkage(cluster1 = cluster[x],cluster2=cluster[y],datajarak=datajarak, idclust1 = x, idclust2 = y))
				else:
					sys.exit("Error pada fungsi linkage")

		jarak.sort(key=itemgetter(2))
		
		
		for x in range(len(cluster[jarak[0][1]])):
			cluster[jarak[0][0]].append(cluster[jarak[0][1]][x])
		del cluster[jarak[0][1]]		
	
	for x in range(len(cluster)):
		print("Jumlah data pada cluster ke " + str(x+1) + " = " + str(len(cluster[x])))

datasetlist = []
nilaimaxdata = []

namafile = input('Masukkan nama file yang digunakan : ')
readFile(filename = namafile,datasetlist = datasetlist, nilaimaxdata = nilaimaxdata)
jumlahcluster = int(input('Masukkan jumlah cluster yang diinginkan : '))

while True:
	print("1. K-Means")
	print("2. Hierarchical")
	metode =  int(input('Masukkan metode yang diinginkan : '))

	if metode == 1:
		kmeans(datasetlist = datasetlist, jumlahcluster = jumlahcluster, nilaimaxdata = nilaimaxdata)
	elif metode == 2:
		print("1. Single Linkage")
		print("2. Centroid Linkage")
		print("3. Complete Linkage")
		print("4. Average Linkage")
		metodepenghitunganjarak =  int(input('Masukkan metode penghitungan jarak yang diinginkan : '))

		if metodepenghitunganjarak not in range(1,5):	
			sys.exit("Unknown Input")

		linkage(datasetlist = datasetlist, jumlahcluster = jumlahcluster, panjangdimensi = len(nilaimaxdata),metodepenghitunganjarak = metodepenghitunganjarak)
	else:
		sys.exit("Unknown Input")

	while True:
		lagi = input('Coba lagi ? [y/n] : ')
		if lagi in ["y","Y","n","N"]:
			break

	if lagi in ["n","N"]:
		break
	print("")
	print("")

