# 分组  
分组






### 分组列表  
----
**功能：**通过多个筛选条件来查询分组列表  
**请求方式：**`GET`  
**请求地址：**  
```
/groups  
```
**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|name|string|可选|通过名称筛选|
|extends_info|string|可选|通过描述筛选|
|system_id|id|可选|通过关联关系 `system_id` 筛选|
|parent_group_id|id|可选|通过关联关系 `parent_group_id` 筛选|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
    "count": 0, // 查询出来的分组数量
    "data": [], // 查询出来的分组数组
}
```
分组数组包含多个分组结构，单个结构的格式为
```json
{
    "id": 0, // 主键
    "name": "string", // 名称 
    "extends_info": "string", // 描述 
    "system_display": "", // 关联关系 `system` 的文字化展示
    "parent_group_display": "", // 关联关系 `parent_group` 的文字化展示
    "create_time": "2021-06-12 17:19:06", // 创建时间
    "update_time": "2021-06-12 17:19:06", // 最后一次修改时间
}
```









### 添加分组 
----
**功能：**添加分组  
**请求方式：**`POST`  
**请求地址：**  
```
/groups/add  
```
**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|system_id|id|必传|设置分组所属的系统，此处传系统的`id`|
|parent_group_id|id|可选|设置分组所属的分组，此处传分组的`id`|
|name|string|必传|名称|
|extends_info|string|可选|描述|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}
```












### 修改分组 
----
**功能：**修改分组  
**请求方式：**`POST`  
**请求地址：**  
```
/groups/update/{{group_id}}  
```
**`URL`中的变量：**  

|变量键名|类型|必传|描述|
|----|----|----|----|
|group_id|id|必传|分组的主键，`id`|

**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|system_id|id|必传|设置分组所属的系统，此处传系统的`id`|
|parent_group_id|id|可选|设置分组所属的分组，此处传分组的`id`|
|name|string|必传|名称|
|extends_info|string|可选|描述|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}
```













### 删除分组 
----
**功能：**删除分组  
**请求方式：**`POST`  
**请求地址：**  
```
/groups/delete/{{group_id}}  
```
**`URL`中的变量：**  

|变量键名|类型|必传|描述|
|----|----|----|----|
|group_id|id|必传|分组的主键，`id`|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}

```



