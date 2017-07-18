import urllib.parse
class UrlManager(object):

    def __init__(self):
        self.rootUrl = 'http://www.ubiaoqing.com/'
        self.search_url = set()

    def mixUrl(self, arg):
        new_arg = urllib.parse.quote(arg)
        self.search_url = self.rootUrl + 'search/' + new_arg
        return self.search_url