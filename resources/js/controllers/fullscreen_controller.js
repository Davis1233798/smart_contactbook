export default class extends Controller {

  // 初始化
  connect() {
      const self = this;
  }

  toggle() {
      const self = this;

      const url = new URL(window.location.href);
      const urlParams = new URLSearchParams(url.search);

      // 準備全畫面遮罩訊息
      const mask = document.createElement('div');
      const message = document.createElement('h1');
      mask.className = 'fullscreen-mask';
      message.className = 'message';
      mask.appendChild(message);

      // 如果目前是 fullscreen 模式，轉跳至非 fullscreen
      if (!urlParams.has("fullscreen")) {
          const zoom = self.data.get('zoom');
          urlParams.set("fullscreen", zoom)
          url.search = urlParams.toString();
          message.innerText = self.data.get('enter-message');
          document.body.appendChild(mask);
          setTimeout(function () {
              window.location.href = url.toString();
          }, 200)

      } else {
          urlParams.delete("fullscreen")
          url.search = urlParams.toString();
          message.innerText = self.data.get('exit-message');
          document.body.appendChild(mask);
          setTimeout(function () {
              window.location.href = url.toString();
              document.exitFullscreen()
          }, 200)
      }
  }

}
