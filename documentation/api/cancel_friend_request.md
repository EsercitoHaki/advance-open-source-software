# API Endpoint: Cancel Friend Request

## Overview
API này cho phép người dùng hủy bỏ lời mời kết bạn mà họ đã gửi cho người dùng khác. Chỉ người gửi lời mời mới có quyền hủy bỏ lời mời đó.

## Endpoint

```
DELETE /api/v1/friends/requests/{requestId}/cancel
```

## Authentication
Yêu cầu token JWT trong header Authorization.

```
Authorization: Bearer {your_jwt_token}
```

## Parameters

| Parameter | Type   | Required | Description                          |
|-----------|--------|----------|--------------------------------------|
| requestId | string | Yes      | ID của lời mời kết bạn cần hủy bỏ   |

## Response

### Success Response (200 OK)

```json
{
  "success": true,
  "message": "Đã xóa lời mời kết bạn thành công"
}
```

### Error Response (400 Bad Request)

```json
{
  "success": false,
  "message": "Không tìm thấy lời mời kết bạn"
}
```

HOẶC

```json
{
  "success": false,
  "message": "Bạn không có quyền xóa lời mời kết bạn này"
}
```

HOẶC

```json
{
  "success": false,
  "message": "Lời mời kết bạn đã được xử lý trước đó"
}
```

### Error Response (401 Unauthorized)

```json
{
  "message": "Unauthenticated."
}
```

## Example Usage

### Request

```
DELETE /api/v1/friends/requests/12345/cancel
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

### Success Response

```json
{
  "success": true,
  "message": "Đã xóa lời mời kết bạn thành công"
}
```

## Implementation Notes

- Chỉ người dùng đã gửi lời mời kết bạn mới có thể hủy bỏ lời mời đó
- Lời mời cần phải ở trạng thái "pending" mới có thể bị hủy bỏ
- Sau khi hủy bỏ, lời mời sẽ bị xóa khỏi hệ thống
- Endpoint này có thể được sử dụng từ giao diện danh sách lời mời đã gửi
