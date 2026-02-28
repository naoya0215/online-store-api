<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# ターミナル1: Laravel API（ポート8000）
cd Desktop/オンラインストア/online-store-api
php artisan serve
# → http://localhost:8000

# ターミナル2: Next.js フロントエンド（ポート3000）  
cd Desktop/オンラインストア/online-store-api/online-store-frontend
npm run dev
# → http://localhost:3000


推奨AWSアーキテクチャ
基本構成
インターネット
      ↓
CloudFront (CDN)
      ↓
ALB (Application Load Balancer)
      ↓
┌─────────────┬─────────────┐
│パブリック    │プライベート  │
│サブネット    │サブネット    │
│             │             │
│Next.js      │Laravel API  │
│(EC2)        │(EC2)        │
│             │      ↓      │
│             │RDS(MySQL)   │
│             │ElastiCache  │
└─────────────┴─────────────┘
必要なAWSサービス一覧
1. コンピューティング・ネットワーク

EC2 - アプリケーションサーバー
VPC - ネットワーク環境
ALB - 負荷分散
CloudFront - CDN（画像・静的ファイル配信）

2. データベース・キャッシュ

RDS（MySQL/PostgreSQL） - メインデータベース
ElastiCache（Redis） - セッション・キャッシュ

3. ストレージ・ファイル管理

S3 - 商品画像、ファイル保存
EBS - EC2のディスク

4. 監視・ログ・セキュリティ

CloudWatch - 監視・ログ管理
IAM - 権限管理
ACM - SSL証明書

5. 通知・メール

SES - メール送信
SNS - 通知システム

学習ロードマップ
Phase 1: 基礎知識（1-2週間）
1. AWS基礎概念
   - リージョン・AZ
   - VPC・サブネット
   - セキュリティグループ

2. 実践
   - EC2インスタンス起動
   - RDS作成
   - S3バケット作成
Phase 2: ネットワーク構築（1週間）
1. VPC設計
   - パブリック/プライベートサブネット
   - インターネットゲートウェイ
   - NATゲートウェイ

2. セキュリティ設定
   - セキュリティグループ
   - NACLs
Phase 3: アプリケーション構築（2-3週間）
1. Laravel API サーバー構築
2. Next.js フロントエンド構築  
3. データベース接続
4. ファイルアップロード（S3）
具体的な構築手順
ステップ1: VPC・ネットワーク構築
1. VPC作成 (10.0.0.0/16)
2. サブネット作成
   - パブリック: 10.0.1.0/24, 10.0.2.0/24
   - プライベート: 10.0.11.0/24, 10.0.12.0/24
3. インターネットゲートウェイ作成・アタッチ
4. NATゲートウェイ作成
5. ルートテーブル設定
ステップ2: データベース構築
1. RDSサブネットグループ作成
2. RDS(MySQL)インスタンス作成
   - マルチAZ: 本番環境では有効
   - バックアップ設定
3. ElastiCache (Redis)作成
   - セッション管理用
ステップ3: アプリケーションサーバー構築
1. EC2インスタンス作成（Laravel API用）
   - Amazon Linux 2
   - PHP, Composer, Laravel セットアップ
   - プライベートサブネットに配置

2. EC2インスタンス作成（Next.js用）
   - Node.js セットアップ  
   - パブリックサブネットに配置
ステップ4: ロードバランサー・CDN設定
1. ALB作成
   - ターゲットグループ設定
   - ヘルスチェック設定

2. CloudFront設定
   - 静的ファイル配信
   - S3オリジン設定
機能別AWS活用方法
商品画像・ファイル管理
S3活用:
- 商品画像保存
- CSVアップロード
- バックアップファイル

CloudFront活用:
- 画像の高速配信
- キャッシュ設定
決済・API連携
Laravel側で実装:
- GMO決済API呼び出し
- ヤマト運輸API連携
- Webhook受信

セキュリティ:
- API キーはAWS Systems Manager Parameter Storeで管理
メール機能
SES設定:
- 注文確認メール
- パスワードリセット
- 配送通知メール

SNS活用:
- 在庫切れ通知
- システムアラート
分析・ダッシュボード
CloudWatch:
- アプリケーションメトリクス
- カスタムメトリクス

RDS:
- 売上分析クエリ
- 顧客分析