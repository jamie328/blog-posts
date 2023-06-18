# 問題一
   Q: 假定有 posts 與 comments 兩張 table。 posts 有 title, content 兩個欄位， comments 有 messages 欄
   位。 請以 laravel 設計並實作新增 comment 與 post 的 api ，並將 comments 與 posts 相關聯。缺少的
   欄位 可自行補足，實作能以 github 等方式提供。  

   A: 簡單拆分 Controller/Repository/UseCase 架構，Controller 作為進入點，UseCase 為處理商業邏輯，
      UseCase 中的 Request 作為過濾資料，在觸碰資料庫前，會驗證進入的資料是否符合商業邏輯，並針對不同錯誤，
      回拋可讀的錯誤訊息給前端或其他工程師，如無錯誤回傳正確資訊。
      想像這是一個留言板系統，一個文章有多個留言，因題目並無過多限制，因此客製化一些欄位，因應彈性化業務發展，
      如遇到共用商業邏輯，則會寫在 Service，但還是會依照公司寫作風格去做因應與變化。  
      實作詳情可以參照 `jamie328/blog-posts/app` 的內容。 
  
# 問題二    
   Q: PHP 當中的 interface 和 abstract ，分別適合於什麼時機使用。請描述對於這兩個保留字的看法。  

   A:
   ## 介面 Interface
   * 定義這個 Class 應該實現的方法，但不去實作其方法，且不可被實例化。
   * 一個 Class 可以 implement 一個以上的 Interface
   * 在子類別實作其方法
   * 父介面 Interface 可以繼承多個子介面 Interface
   * 使用時機：如果此功能為這個 Class "部分" 群體有的方法，可用 Interface，
      例如：動物有很多種，但不是每一種都能飛，飛就很適合用於 Interface，在不同動物類別再去定義如何飛，
      狗不會飛，牠不用實作"飛"，鳥會飛，實作"飛"

   ## 抽象 Abstract
   * 抽象為父類別(Class)，只能被繼承，無法被實例化
   * Abstract class 包含其 Class 實現的方法，但一樣不實作，交給子類別(Class) 去實作
   * 父類別只能繼承單個 Abstract class
   * 使用時機：如果此功能為這個 Class "全部" 群體有的方法，可用 Abstract，
     例如：動物都會"叫"，就可以定義 abstract class Animal 有 "叫" 共同功能，然後在每個動物去定義如何叫，
     狗是汪汪叫，貓是喵喵叫
# 問題三
   Q: Laravel 當中的 middleware 能夠在進入 controller 和離開 controller 後提供額外的操作，參考 官方文件
   。若換成自己設計類似的 middleware ，請描述一下會如何設計以及設計的做法。注意：不是如何使用
   middleware，而是假設自己為 laravel 作者，設計 middleware 供他人使用
   
   A:  
   這個問題很好，如果要設計一個 middleware 供他人使用，首先會先確認此 middleware 在各種情境下的應用、並思考在
   router 進入後，此 middleware 與其他 middleware 的優先順序排列，錯誤時的控制等等，最後，才去思考這個 middleware
   內的實作邏輯，並在開發前可與團隊成員討論，在開發前確認 middleware 方向是否走偏。
   舉例：我要做一個後台權限檢查的 middleware，我的步驟呈現如下：  
   A. 設計階段  

        1. trace 目前專案是否有相同 middleware，並詢問其他工程師其他專案是否有相同機制，以了解更多背景與知識
        2. 定義此 middleware 功能與目的，功能與目的：在進入後台之前，檢查使用者是否有權限進行後台操作
        3. 區分使用不同身份與情境，例如：訪客、內部使用者、廠商、客戶等等
        4. 簡單劃出 進入 router 後，會經過哪些 middleware，並列出其優先順序與相對關係
        5. 試想不同錯誤時的控制，包含權限檢查不足或是身份過期等等，要做哪些相對應的處理，導頁或紀錄 Log 等等

   B. 團隊討論：如功能牽扯重大，將上述 1~5 列成文件，簡單向團隊說明，或是以訊息軟體簡單通知其 middleware 的討論文件，
      並將其問題與討論解決後，再進行後續動作。

   C. 實作：
        根據 A 與 B 去實作 middleware。           
    1. `php artisan make:middleware AdminAuthMiddleware`  
    2. AdminAuthMiddleware
```php 
class AdminAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // 檢查使用者是否已經登入，否，則跳至登入頁
        
        // 檢查使用者是否為訪客，是則，導回訪客頁面
        
        // 檢查使用者是否為廠商或是客戶，是則，導回後台頁面(只具有某些頁面可修改功能，大部分為只能讀)
        
        // 檢查使用者是否為內部員工，是則，導回後台頁面(具有大多數頁面修改刪除等操作功能)

        return $next($request);
    }
}
```  
  3. 做其他程式設定 Kernel 等等

D. 測試與其他部門溝通告知

E. 撰寫文件，並告知團隊，文件位置、使用細節、操作方式、提供範例
