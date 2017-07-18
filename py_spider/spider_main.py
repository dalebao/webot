import sys
import parser
import downloader
import url_manager

class SpiderMain(object):
    def __init__(self):
        self.url = url_manager.UrlManager()
        self.downloader = downloader.Downloader()
        self.parser = parser.Parser()
        self.arg = set()
        arg_len = len(sys.argv)
        if arg_len == 0 or sys.argv == None:
            pass
        self.arg = sys.argv[1]

    def craw(self):
        if self.downloader.pathExists(self.arg):
            print("文件已存在")
            return
        # 获得搜索链接
        search_url = self.url.mixUrl(self.arg)
        # 下载网页
        content = self.downloader.download(search_url)
        # 解析网页 获得 图片链接
        pic_urls = self.parser.parse(content)
        # 保存图片
        self.downloader.saveImage(pic_urls, self.arg)




if __name__ == '__main__':
    spider = SpiderMain()
    spider.craw()

