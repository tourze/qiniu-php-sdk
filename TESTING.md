# 七牛 PHP SDK 测试指南

## 环境准备

### 1. 配置环境变量

测试需要七牛云账号凭据。请按以下步骤配置：

```bash
# 复制环境配置模板
cp .env.test .env

# 编辑 .env 文件，填入您的七牛云凭据
# QINIU_ACCESS_KEY=your_actual_access_key
# QINIU_SECRET_KEY=your_actual_secret_key
# QINIU_TEST_BUCKET=your_test_bucket_name
```

### 2. 创建测试 Bucket

在七牛云控制台创建一个专门用于测试的 bucket，并将名称配置到 `QINIU_TEST_BUCKET` 环境变量中。

### 3. 设置环境变量

#### 方法一：临时设置（推荐用于本地测试）
```bash
export QINIU_ACCESS_KEY="your_access_key"
export QINIU_SECRET_KEY="your_secret_key"
export QINIU_TEST_BUCKET="your_test_bucket"
```

#### 方法二：使用 .env 文件（需要额外配置）
如果项目使用了 phpdotenv，环境变量会自动加载。

## 运行测试

### 运行所有测试
```bash
# 在包目录中
../../vendor/bin/phpunit

# 或从项目根目录
./vendor/bin/phpunit packages/qiniu-php-sdk/tests
```

### 运行特定测试
```bash
# 运行单个测试类
../../vendor/bin/phpunit tests/Qiniu/Tests/AuthTest.php

# 运行单个测试方法
../../vendor/bin/phpunit --filter testSign tests/Qiniu/Tests/AuthTest.php
```

### 跳过需要真实 API 的测试
```bash
# 使用测试分组（如果配置了）
../../vendor/bin/phpunit --exclude-group integration
```

## 测试说明

### 单元测试 vs 集成测试

- **单元测试**：不需要网络访问，使用模拟数据
  - AuthTest 中的签名测试
  - 工具类方法测试

- **集成测试**：需要真实的七牛云 API 访问
  - 文件上传测试
  - Bucket 管理测试
  - CDN 操作测试

### 常见问题

1. **"Call to a member function on null" 错误**
   - 确保已正确设置环境变量
   - 检查 `$testAuth` 是否正确初始化

2. **API 请求失败**
   - 验证 Access Key 和 Secret Key 是否正确
   - 确认测试 bucket 存在且有权限访问
   - 检查网络连接

3. **测试超时**
   - 某些测试（如大文件上传）可能需要较长时间
   - 可以通过 `--timeout` 参数调整超时时间

## 持续集成

在 CI/CD 环境中，建议：

1. 使用专门的测试账号
2. 将凭据配置为加密的环境变量
3. 考虑跳过需要真实 API 的测试，仅在特定条件下运行

## 贡献代码

提交代码前请确保：

1. 所有相关测试通过
2. 新功能包含对应的测试用例
3. 测试覆盖率不降低