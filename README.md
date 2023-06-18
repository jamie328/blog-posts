# 問題一
   Q: 假定有 posts 與 comments 兩張 table。 posts 有 title, content 兩個欄位， comments 有 messages 欄
   位。 請以 laravel 設計並實作新增 comment 與 post 的 api ，並將 comments 與 posts 相關聯。缺少的
   欄位 可自行補足，實作能以 github 等方式提供。
   A: 簡單拆分 Controller/Repository/UseCase 架構，Controller 作為進入點，UseCase 為處理商業邏輯，
      UseCase 中的 Request 作為過濾資料，在觸碰資料庫前，會驗證進入的資料是否符合商業邏輯，並針對不同錯誤，
      回拋可讀的錯誤訊息給前端或其他工程師，如無錯誤回傳正確資訊。
      想像這是一個留言板系統，一個文章有多個留言，因題目並無過多限制，因此客製化一些欄位，因應彈性化業務發展，
      如遇到共用商業邏輯，則會寫在 Service，但還是會依照公司寫作風格去做因應與變化。
  
# 問題二    
   Q: PHP 當中的 interface 和 abstract ，分別適合於什麼時機使用。請描述對於這兩個保留字的看法。
   A: 

# 問題三
   Q: Laravel 當中的 middleware 能夠在進入 controller 和離開 controller 後提供額外的操作，參考 官方文件
   。若換成自己設計類似的 middleware ，請描述一下會如何設計以及設計的做法。注意：不是如何使用
   middleware，而是假設自己為 laravel 作者，設計 middleware 供他人使用

請於三天內完成測驗，填寫完畢請回傳您的答案，我們將請用人單位進一步評估結果。謝謝。


