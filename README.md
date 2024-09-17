## 設計模式

### Controller-Service-Repository Patterm

依此模式已開發過多個專案，大多能解決各種需求，因此採用此模式開發本次測驗。

- Controller 負責管理 REST Interface，將通過 validation 的資料傳遞予 Service
- Service 負責處理 Business Logic，以本次的需求為例，Service 負責將資料整理為 Order、Bnb 以及 OrderCurrency，並判斷 Order、Bnb 的資料存在與否，做出相對應的處理
- Repository 負責處理資料，包含存取資料庫以及與第三方的 API 聯繫，本次的需求僅需存取資料庫

## 設計原則

### 單一職責

遵循上述設計模式，Controller、Service、Repository 的職責單一且明確

### 開放/封閉原則

遵循上述設計模式，在新增或是修改功能時將更富彈性，並不影響其他功能。例如增加刪除 Order 的功能時，僅需要於 Controller 新增 delete action，並在 Service 實作刪除時的 Business Logic，最後在 Repository 增加刪除功能即可。亦不會影響到原有的儲存或閱覽 Order 功能。

### Liskov替換

本實作定義了各 Service，Repository 應有的功能，如果 Order 的存取由資料庫改為第三方 API 時，僅需開發新的 Repository 並 bind 至 Interface 即可。就算替換子類別也不會影響程式架構。

### 介面隔離

本實作並無著墨於此原則。

### 依賴反轉

本實作利用 Laravel 的 Dependency Injection，實現依賴反轉原則。