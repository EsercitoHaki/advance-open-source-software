# API Endpoint: Search Users by Username

## Overview

API này cho phép tìm kiếm người dùng theo username, giúp dễ dàng tìm kiếm bạn bè để kết bạn.

## Endpoint

```
GET /api/v1/users/search
```

## Authentication

Yêu cầu token JWT trong header Authorization.

```
Authorization: Bearer {your_jwt_token}
```

## Query Parameters

| Parameter | Type    | Required | Description                                          |
| --------- | ------- | -------- | ---------------------------------------------------- |
| username  | string  | Yes      | Username cần tìm kiếm (ít nhất 1 ký tự)              |
| limit     | integer | No       | Giới hạn số lượng kết quả (mặc định: 10, tối đa: 50) |

## Response

### Success Response (200 OK)

```json
{
    "success": true,
    "message": "Tìm kiếm người dùng thành công",
    "data": [
        {
            "user_id": "user123",
            "username": "johnsmith",
            "full_name": "John Smith",
            "avatar": "default-avatar.png",
            "email": "john@example.com"
        },
        {
            "user_id": "user789",
            "username": "johndoe",
            "full_name": "John Doe",
            "avatar": "uploads/avatars/john.jpg",
            "email": "johndoe@example.com"
        }
        // More users matching the search...
    ]
}
```

### Error Response (422 Unprocessable Entity)

```json
{
    "success": false,
    "message": "Dữ liệu không hợp lệ",
    "errors": {
        "username": ["The username field is required."]
    }
}
```

### Error Response (401 Unauthorized)

```json
{
    "message": "Unauthenticated."
}
```

### Error Response (500 Internal Server Error)

```json
{
    "error": true,
    "message": "Có lỗi xảy ra khi tìm kiếm người dùng: {error_message}"
}
```

## Example Usage

### Request 1: Search for users with username containing "john"

```
GET /api/v1/users/search?username=john
```

### Request 2: Search for users with username containing "john", with limit of 5 results

```
GET /api/v1/users/search?username=john&limit=5
```

## Implementation Notes

-   API này thực hiện tìm kiếm không phân biệt chữ hoa/thường với username.
-   Kết quả tìm kiếm không bao gồm người dùng hiện tại đang thực hiện tìm kiếm.
-   Kết quả được giới hạn để đảm bảo hiệu suất (mặc định: 10 người dùng).
-   API này phù hợp để hiển thị kết quả tức thì trong quá trình nhập để tìm kiếm người dùng.
-   Kết quả chỉ chứa thông tin cơ bản của người dùng, đặc biệt là thông tin cần thiết để hiển thị trong danh sách kết quả tìm kiếm và gửi lời mời kết bạn.
