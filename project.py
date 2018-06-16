import time
import requests
from bs4 import BeautifulSoup
from datetime import date
import datetime
import gi
gi.require_version('Notify','0.7')
from gi.repository import Notify
import re
re.compile('<title>(.*)</title>')
Notify.init("Test Notifier")


page = requests.get("https://www.fatmarathoner.com/marathon-calendar/")
soup = BeautifulSoup(page.content, 'html.parser')
# print(soup.prettify())
# print(soup.find_all("tr")[10])
size = len(soup.find_all("tr"))

for i in range(2,size+1):
    if i%2==0:
        row = (soup.find(class_="row-"+str(i)+" even"))
    else:
        row = (soup.find(class_="row-" + str(i) + " odd"))
    daday = (row.find(class_="column-1")).get_text()
    name = (row.find(class_="column-2")).get_text()
    city = (row.find(class_="column-3")).get_text()
    category = (row.find(class_="column-4")).get_text()
    # r = re.compile("([a-zA-Z]+)([0-9]+)")
    k = re.split(r'(\d+)', daday)[1:3]
    # print(k)
    # print(int(k[0]))
    global d1
    d0 = date(datetime.datetime.now().year,datetime.datetime.now().month,datetime.datetime.now().day)

    if k[1]==' Jan':
        d1 = date(2018, 1, int(k[0]))
    elif k[1]==' Feb':
        d1 = date(2018, 2, int(k[0]))
    elif k[1]== ' Mar':
        d1 = date(2018, 3, int(k[0]))
    elif k[1] == ' Apr':
        d1 = date(2018, 4, int(k[0]))
    elif k[1] == ' May':
        d1 = date(2018, 5, int(k[0]))
    elif k[1] == ' Jun':
        d1 = date(2018, 6, int(k[0]))
    elif k[1] == ' July':
        d1 = date(2018, 7, int(k[0]))
    elif k[1] == ' Aug':
        d1 = date(2018, 8, int(k[0]))
    elif k[1] == 'Sep':
        d1 = date(2018, 9, int(k[0]))
    elif k[1] == ' Oct':
        d1 = date(2018, 10, int(k[0]))
    elif k[1] == ' Nov':
        d1 = date(2018, 11, int(k[0]))
    elif k[1] == ' Dec':
        d1 = date(2018, 12, int(k[0]))
    delta = d1 - d0
    print("No of days: " + str(delta.days))
    print(daday + " " + name + " " + city + " " + category)
    if city=='Benguluru' and int(str(delta.days))<=7 and int(str(delta.days))>0:
        notification = Notify.Notification.new(name + "   " + daday)
        notification.show()
        time.sleep(10)

Notify.uninit();
# print(datetime.datetime.now().strftime("%y %m %d %H %M"))


# print(soup.find_all(class))*