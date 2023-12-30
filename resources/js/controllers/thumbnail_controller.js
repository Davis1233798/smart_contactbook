import {Fancybox} from "@fancyapps/ui";

export default class extends window.Controller {

    connect() {
        // console.log("connect!!");
    }

    showImage(event) {
        event.preventDefault();

        if (this.data.get('is-empty') !== 'no') {
            return false
        }

        const gallery = this.data.get('gallery');

        if ( gallery.length > 0 ) {

            const myArray = JSON.parse(this.data.get('gallery'));
            // console.dir(myArray);

            // 圖片集 (左右切換圖片)
            let tempData = [];
            for ( let i = 0; i < myArray.length; i++ ) {
                tempData.push(
                    {
                        src: myArray[i],
                        type: "image",
                        showClass: false,
                        infinite: false,
                    }
                );
            }
            // console.dir(tempData);

            Fancybox.show(tempData);

        } else {

            // 單張圖片
            Fancybox.show([{
                src:  this.data.get('value').length > 0 ? this.data.get('value') : this.data.get('url'),
                type: "image",
                showClass: false,
                infinite: false,
            }]);

        }

        return false;
    }
}
