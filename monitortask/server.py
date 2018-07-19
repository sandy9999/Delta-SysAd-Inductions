from flask import Flask, flash, redirect, render_template, request, session, url_for
import pymysql

app = Flask(__name__)

@app.route("/url1",methods=["GET","POST"])
def url1():
    req_data = request.get_json()
    mempercent = req_data["memory_usage"]
    cpu = req_data["cpu_usage"]
    disk = req_data["disk_usage"]
    uptime = req_data["uptime"]
    netconnects = req_data["active_connections"]
    maxmemproc = req_data["maxmem_process"]
    timestamp = req_data["timestamp"]
    db = pymysql.connect("localhost", "phpmyadmin", "" , "task")
    cursor = db.cursor()       
    cursor.execute("INSERT INTO monitortask (mempercent,cpu,disk,uptime,netconnects,maxmemproc,timestamp) VALUES ('%s','%s','%s','%s','%s','%s','%s')" % (mempercent,cpu,disk,uptime,netconnects,maxmemproc,timestamp))
    db.commit()
    db.close()
    return redirect(url_for("url1"))

@app.route("/url2",methods=["GET","POST"])
def url2():
    db = pymysql.connect("localhost","phpmyadmin","","task")
    cursor = db.cursor()
    cursor.execute("SELECT mempercent,cpu,disk,uptime,netconnects,maxmemproc,timestamp FROM monitortask ORDER BY id DESC LIMIT 10")
    data = cursor.fetchall()
    db.close()
    return render_template("url2.html",data=data)

if __name__=="__main__":
    app.run(debug=True,host='0.0.0.0')

