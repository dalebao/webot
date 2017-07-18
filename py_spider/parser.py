from bs4 import BeautifulSoup
import re



class Parser(object):



    def _get_new_url(self, soup):
        new_urls = set()

        links = soup.find_all('img',{'class':'img-responsive center-block'},limit=100)
        for link in links:
            if link['alt'] != u'U表情包官方小程序二维码':
                new_urls.add(link['src'])
        return new_urls
    def parse(self, content):
        if content is None:
            return

        soup = BeautifulSoup(content, 'html.parser', from_encoding='utf-8')

        pic_urls = self._get_new_url(soup)

        return pic_urls

