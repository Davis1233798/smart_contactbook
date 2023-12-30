export default class extends window.Controller {

    connect() {
        // console.log('Modal controller connected!');
    }

    setCoHostContent(data) {
        document.querySelector('.formMethod').innerHTML = data.formmethod;
        document.querySelector('.formAction').innerHTML = data.formaction;
        document.querySelector('.urlParameters').innerHTML = data.urlparameters;
        document.querySelector('.elementName').innerHTML = data.elementname;
        document.querySelector('.fileCount').innerHTML = data.filecount;
        document.querySelector('.acceptedFiles').innerHTML = data.acceptedfiles;
        document.querySelector('.maxFileSize').innerHTML = data.maxfilesize;
        document.querySelector('.maxFiles').innerHTML = data.maxfiles;
        document.querySelector('.thisId').innerHTML = data.thisid;
    }

    open() {
        // 移除錯誤訊息
        let helpblock = document.querySelector( '.help-block' );
        if (helpblock) {
            helpblock.parentNode.removeChild( helpblock );
        }
    
        // 清空欄位值
        document.querySelector('input[name = "files"]').value = "";
    
        document.querySelector('.modal-backdrop').style.display = "block";
        document.querySelector('.uploadModal').style.display = "block";
        document.querySelector('.uploadModal').classList.add("show");
    }
    
    close() {
        document.querySelector('.modal-backdrop').style.display = "none";
        document.querySelector('.uploadModal').style.display = "none";
        document.querySelector('.uploadModal').classList.remove("show");
    }

    saveFile() {

        // 移除錯誤訊息
        let helpblock = document.querySelector( '.help-block' );
        if (helpblock) {
            helpblock.parentNode.removeChild( helpblock );
        }

        // 傳輸方法
        const formMethod = document.querySelector('.formMethod').innerHTML;

        // 傳輸網址
        const formAction = document.querySelector('.formAction').innerHTML;
        
        // 網址參數
        const urlParameters = document.querySelector('.urlParameters').innerHTML;

        // 檔案個數上限
        const maxFiles = Number(document.querySelector('.maxFiles').innerHTML);

        // 檔案容量上限
        const maxFileSize = Number(document.querySelector('.maxFileSize').innerHTML);

        // 檔案格式限制
        const acceptedFiles = document.querySelector('.acceptedFiles').innerHTML;

        // 檔案所屬編號
        const thisId = Number(document.querySelector('.thisId').innerHTML);

        // 資料庫已存在的檔案個數
        const fileCount = Number(document.querySelector('.fileCount').innerHTML);

        // 元件名稱
        const elementName = document.querySelector('.elementName').innerHTML;
        
        // 其他變數
        let totalFiles = document.querySelector('input[name = "files"]').files.length;
        let filesBlock = document.querySelector( '.files-block' );
        let formPath = "";
        let realTotalFiles = 0;
        let targetClassName = "."+elementName;

        // console.log();

        // 實際檔案個數 = 資料庫已存在的檔案個數 + 現在要上傳的檔案個數
        realTotalFiles = totalFiles + fileCount;

        if (totalFiles > 0 ) {

            // 檢查檔案個數上限
            // console.log(typeof realTotalFiles);
            // console.log(typeof totalFiles);
            // console.log(typeof maxFiles);
            if (realTotalFiles > maxFiles) {
                filesBlock.innerHTML +=
                "<small class='help-block'>總檔案數 限制 "+ maxFiles +" 個</small>";
            } else {

                if (!formAction) {
                    return;
                }
            
                formPath = formAction + '/store';
                // console.log(formPath);

                let formData = new FormData();
                let success = "Y";
                let errorSizeString = "";
                let errorExtString = "";

                // Read selected files
                for (let index = 0; index < totalFiles; index++) {
                    
                    formData.append("files[]", document.querySelector('input[name = "files"]').files[index]);

                    // 取得檔案資訊
                    let file = document.querySelector('input[name = "files"]').files[index];
                    let fileName = file.name;
                    let fileSize = file.size / 1024 / 1024;
                    // let fileExt = fileName.split('.').pop();

                    // 檢查檔案容量上限
                    fileSize = Number(fileSize.toFixed(2));  // 四捨五入，保留兩位小數

                    // console.log(typeof fileSize);
                    // console.log(typeof maxFileSize);
                    if (fileSize > maxFileSize) {
                        errorSizeString += fileName +  " 檔案大小( " + fileSize + " MB )超過上限<br/>";
                    }

                    // 檢查檔案格式限制
                    if ( this.fileValidation(fileName, acceptedFiles) === false ) {
                        errorExtString += fileName +  " 檔案類型錯誤<br/>";
                    }
                    
                } // next

                if (errorSizeString !== "" || errorExtString !== "") {
                    filesBlock.innerHTML += "<small class='help-block'>檔案上傳失敗！<br/><br/>" + errorSizeString + errorExtString + "</small>";
                } else {
                    formData.append("urlParameters", urlParameters);
                    this.close();

                    if (thisId!=0) {
                        // 此 spinner 會讓畫面值 reset，不可用於新增頁面
                        document.body.innerHTML += '<div class="loading"></div>';
                        const loadingDiv = document.querySelector('.loading');
                        loadingDiv.style.visibility = 'visible';
                    }

                    // AJAX 寫入
                    axios.post(formPath, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        }
                    })
                    .then((response) => {
                        
                        if (thisId==0) {
                            const ids = response.data;
                            let attachmentIds = [];

                            for (let i = 0; i < ids.length; i++) {
                                attachmentIds.push(ids[i]);
                            }

                            formPath = formAction + '/show';
                            // console.log(formPath);

                            // save the table to a var
                            let table = document.querySelector(targetClassName);
                            // save table body to a var. select the first occurrence of tbody element with [0]
                            let tableRef = table.getElementsByTagName('tbody')[0];
                            // count number of <tr>
                            let rowNo = tableRef.rows.length;

                            // send a POST request
                            axios({
                                method: 'post',
                                url: formPath,
                                data: {
                                    urlParameters: urlParameters,    
                                    ids: attachmentIds,
                                    elementName: elementName,
                                    rowNo: rowNo
                                }
                            })
                            .then(function (response) {

                                // console.log('generate a response.');
                                // console.log(response.data.html);
                                // I need this data here ^^
                                // return response.data;
                
                                // save the table to a var
                                // let table = document.querySelector(targetClassName);
                                // save table body to a var. select the first occurrence of tbody element with [0]
                                // let tableRef = table.getElementsByTagName('tbody')[0];
                                // set tbody inner html
                                let newRow = "";
                                newRow += response.data.html;
                                // get the current table body html as a string, and append the new row
                                let newHtml = tableRef.innerHTML + newRow;
                                // draw table
                                tableRef.innerHTML = newHtml;
                                // hide Spinner
                                // loadingDiv.style.visibility = 'hidden';
                                
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                        } else {
                            setTimeout(function(){ 
                                parent.location.reload();
                            }, 1000);
                        }

                    }, (error) => {
                        console.log(error);
                    });
                    
                }
                
            }
        
        } else {
            filesBlock.innerHTML +=
            "<small class='help-block'>檔案名稱 不能空白</small>";
        }
    }

    fileValidation(filename, acceptedfiles) {
        /* getting file extenstion eg- .jpg,.png, etc */
        let extension = filename.substr(filename.lastIndexOf("."));

        /* define allowed file types */
        let allowedExtensionsRegx = /(\.jpeg|\.jpg|\.png|\.bmp|\.xlsx|\.xls|\.docx|\.doc|\.pdf)$/i;
        if (acceptedfiles=='image/*') {
            allowedExtensionsRegx = /(\.jpeg|\.jpg|\.png|\.bmp)$/i;
        }

        /* testing extension with regular expression */
        let isAllowed = allowedExtensionsRegx.test(extension);

        if (!isAllowed) {
            return false;
        }
    }
}