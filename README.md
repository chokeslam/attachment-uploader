# LYRASOFT Attachment Uploader Package

![screenshot 2022-01-13 下午04 01 08](https://user-images.githubusercontent.com/34531644/180942543-b1cdd90e-e743-46af-9888-053a2388d9af.png)

## 安裝

```shell
composer require lyrasoft/attachment
```

然後複製 migration 檔案

```shell
php windwalker pkg:install lyrasoft/attachment -t migrations
```

如果需要更改 entity、repo 時可複製出來

```shell
php windwalker pkg:install lyrasoft/attachment -t migrations -t entity -t attachment_modal
```

## 使用

先到 `unicorn.php` 中註冊 `AttachmentPackage`

```
'unicorn' => [
        
        .....

        'providers' => [
            \Lyrasoft\Attachment\AttachmentPackage::class,
        ],
]
```

```
<x-attachment-field 
    :items="$attachments"
    :insertBtn="true"
    :accept="'pdf,gif'"
    :mutiple="true"
    >
</x-attachment-field>
```

### Options

| name      | require | Desc |
|-----------|---------|---|
| id        | false   | 欄位 id，預設帶隨機碼，需要 JS 控制可以自訂
| name      | false   | 欄位名稱，會自動後綴 `[]`，預設是 `attachments`
| items     | true    | 提供已上傳檔案列表做使用
| insertBtn | false   | 插入文章的btn，可以是 `true` 或 Tinymce element 的選擇器
| accept    | false   | 限制檔案類型
| mutiple   | false   | 可上傳複數檔案

如果要單獨使用 檔案列表 或是 上傳Input的話 也可以單獨使用

```html
<!-- 一般使用，啟動插入文章功能。預設會指定 #input-tiem-fulltext -->
<x-attachment-field :items="$attachments" :insertBtn="true"></x-attachment-field>

<!-- 一般使用，啟動插入文章功能。自訂 Tinymce id -->
<x-attachment-field :accept="'pdf,gif'" :mutiple="true" insertBtn="#input-item-content"></x-attachment-field>

<!-- 頁面上插入第二組時，可以自訂另一個 name -->
<!-- id 也可以自訂，如果沒自訂，會用隨機碼，不會衝突 -->
<x-attachment-field
    id="input-attachments-other"
    name="othert_attachments"
    :accept="'pdf,gif'"
    :mutiple="true"
    insertBtn="#input-item-content"></x-attachment-field>
```

## JS

在需要使用的頁面 ts中 使用 `useAttachment()` 載入

```js
import { useAttachment } from '@lyrasoft/attachment/dist';

useAttachment();
```


## Slot 

如果你想自訂額外的按鈕的動作，可以用 `buttons` slot

```
        <x-attachment-field :items="$attachments">
            <x-slot name="buttons">
                @scope($item, $i)
               
                Do anything with $item
            </x-slot>
        </x-attachment-field>
```

## 元件個別引入

- `<attachment-field>`: 最完整的元件，包含 list & uploader
- `<attachment-uploader>`: 使用 file-drag 做的上傳器
- `<attachment-list>`: 上傳附件列表

### 備註
1. 記得要在 view 中利用`repo` 或是 `ORM` 取出 attachments 並塞入 field 的 option 中。
2. 在controller 內記得寫儲存及刪除的內容, 有刪除檔案的話可以從 `$app->input()` 中取得 `remove_attachments` 裡面是 attachment 的 ID
