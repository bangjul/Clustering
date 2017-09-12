from knn import Data as Data
from operator import itemgetter
import xlrd, sys

def readFile(filename,datasetlist = [],jenis_kelas = []):
	dataset = xlrd.open_workbook(filename)
	dataset = dataset.sheet_by_name('Sheet1')
	start_row = 4

	for x in range(start_row,dataset.nrows):
		data = Data(dataset.cell(x,1).value,dataset.cell(x,2).value,dataset.cell(x,3).value)
		datasetlist.append(data)
		if data.kelas not in jenis_kelas:
			jenis_kelas.append(data.kelas)

def bagisetiapkelas(datasetlist,jenis_kelas,datasetlistsetiapkelas):
	datasetlisttmp = []
	for x in range(0,len(jenis_kelas)):
		for y in range(0,len(datasetlist)):
			if datasetlist[y].kelas == jenis_kelas[x]:
				datasetlisttmp.append(datasetlist[y])
		datasetlistsetiapkelas.append(datasetlisttmp)
		datasetlisttmp = []

def deleteList(listref):
	for x in range(0,len(listref)):
		listref.pop()

def bagi80n20(datasetlist, datasetuntukcoba, jenis_kelas):
	datasetlistsetiapkelas = []

	bagisetiapkelas(datasetlist = datasetlist, jenis_kelas = jenis_kelas, datasetlistsetiapkelas = datasetlistsetiapkelas)

	for x in range(0,len(jenis_kelas)):
		for y in range(0,int(0.2*len(datasetlistsetiapkelas[x]))):
			datasetuntukcoba.append(datasetlistsetiapkelas[x].pop())

	deleteList(listref = datasetlist)

	for x in range(0,len(jenis_kelas)):
		for y in range(0,len(datasetlistsetiapkelas[x])):
			datasetlist.append(datasetlistsetiapkelas[x][y])

def votingf(datasetlist,jarak,jenis_kelas,voting):
	for y in range(0,len(jarak)):
		if datasetlist[jarak[y][0]].kelas not in jenis_kelas:
			jenis_kelas.append(datasetlist[jarak[y][0]].kelas)
			voting.append([datasetlist[jarak[y][0]].kelas,0])
	for y in range(0,len(jarak)):
		for z in range(0,len(jenis_kelas)):
			if datasetlist[jarak[y][0]].kelas == jenis_kelas[z]:
				voting[z][1] += 1

def nearestneighbour(datasetlist,datasetuntukcoba,knn):
	data_benar = 0
	data_salah = 0
	for x in range(0,len(datasetuntukcoba)):
		jarak = []
		for y in range(0,len(datasetlist)):
			jarak.append([y, datasetuntukcoba[x].jarak(datasetlist[y])])
		jarak.sort(key=itemgetter(1))
		jarak = jarak[:knn]
		jenis_kelas = []
		voting = []
		
		votingf(datasetlist = datasetlist,jarak = jarak, jenis_kelas = jenis_kelas, voting = voting)

		print("Array Hasil Voting :")
		voting.sort(key=itemgetter(1),reverse=True)
		print(voting)
		print("Data :")
		print("X :" + str(datasetuntukcoba[x].x))
		print("Y :" + str(datasetuntukcoba[x].y))
		print("Kelas:" + str(datasetuntukcoba[x].kelas))
		print("")
		print("Setelah dihitung menggunakan algoritma NN menghasilkan nilai")
		print("Kelas:" + str(voting[0][0]))
		if datasetuntukcoba[x].kelas == voting[0][0]:
			data_benar += 1
			print("Data benar")
		else:
			data_salah += 1
			print("Data salah")
		print("")

start_row = 4
start_column = 1

datasetlistsetiapkelas = []
datasetuntukcoba = []
datasetlist = []
jenis_kelas = []
jarak = []
voting = []
x = start_row

knn = int(input('Masukan jumlah baris knn: '))

orig_stdout = sys.stdout
sys.stdout=open('OLSYield.txt','w')

readFile(filename = "ruspini.xls",datasetlist = datasetlist, jenis_kelas = jenis_kelas)
bagi80n20(datasetlist = datasetlist, datasetuntukcoba = datasetuntukcoba, jenis_kelas = jenis_kelas)
nearestneighbour(datasetlist = datasetlist, datasetuntukcoba = datasetuntukcoba, knn = knn)


print("Data benar : " + str((data_benar/(data_salah+data_benar))*100) + "%")
orig_stdout = sys.stdout
sys.stdout=open('OLSYield.txt','w')

