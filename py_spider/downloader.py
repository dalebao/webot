
import urllib.request
import urllib.parse
import os

class Downloader(object):

    def download(self, url):
        if url is None :
            return
        content = urllib.request.urlopen(url)
        if content.getcode() != 200:
            return
        return content.read()

    def saveImage(self, urls, name):
        if urls is None or name is None:
            return
        count = 1
        for url in urls:
            path = os.getcwd()+"/images/"+name+"/"+name+str(count)+".png"
            data = urllib.request.urlopen(url).read()
            f = open(path, "wb")
            f.write(data)
            f.close()
            count = count + 1

    def pathExists(self, name):
        if name is None:
            return
        directory = os.getcwd()+"/images/"+name
        if os.path.exists(directory):
            return True
        else:
            os.makedirs(directory)
