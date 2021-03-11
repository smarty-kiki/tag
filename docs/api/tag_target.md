# 标签与目标的关联  
标签与目标的关联






### 标签与目标的关联列表  
----
**功能：**通过多个筛选条件来查询标签与目标的关联列表  
**请求方式：**`GET`  
**请求地址：**  
```
/tag_targets  
```
**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|class|string|可选|通过目标类型筛选|
|class_id|number|可选|通过目标ID筛选|
|description|string|可选|通过描述筛选|
|whatever|string|可选|通过名称筛选|
|system_id|id|可选|通过关联关系 `system_id` 筛选|
|tag_id|id|可选|通过关联关系 `tag_id` 筛选|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
    "count": 0, // 查询出来的标签与目标的关联数量
    "data": [], // 查询出来的标签与目标的关联数组
}
```
标签与目标的关联数组包含多个标签与目标的关联结构，单个结构的格式为
```json
{
    "id": 0, // 主键
    "class": "string", // 目标类型 
    "class_id": 0, // 目标ID 
    "description": "string", // 描述 
    "whatever": "string", // 名称 
    "system_display": "", // 关联关系 `system` 的文字化展示
    "tag_display": "", // 关联关系 `tag` 的文字化展示
    "create_time": "2021-03-11 13:31:17", // 创建时间
    "update_time": "2021-03-11 13:31:17", // 最后一次修改时间
}
```









### 添加标签与目标的关联 
----
**功能：**添加标签与目标的关联  
**请求方式：**`POST`  
**请求地址：**  
```
/tag_targets/add  
```
**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|system_id|id|必传|设置标签与目标的关联所属的系统，此处传系统的`id`|
|tag_id|id|必传|设置标签与目标的关联所属的标签，此处传标签的`id`|
|class|string|必传|目标类型|
|class_id|number|必传|目标ID|
|description|string|可选|描述|
|whatever|string|必传|名称|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}
```












### 修改标签与目标的关联 
----
**功能：**修改标签与目标的关联  
**请求方式：**`POST`  
**请求地址：**  
```
/tag_targets/update/{{tag_target_id}}  
```
**`URL`中的变量：**  

|变量键名|类型|必传|描述|
|----|----|----|----|
|tag_target_id|id|必传|标签与目标的关联的主键，`id`|

**参数：**  

|参数键名|类型|必传|描述|
|----|----|----|----|
|system_id|id|必传|设置标签与目标的关联所属的系统，此处传系统的`id`|
|tag_id|id|必传|设置标签与目标的关联所属的标签，此处传标签的`id`|
|class|string|必传|目标类型|
|class_id|number|必传|目标ID|
|description|string|可选|描述|
|whatever|string|必传|名称|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}
```













### 删除标签与目标的关联 
----
**功能：**删除标签与目标的关联  
**请求方式：**`POST`  
**请求地址：**  
```
/tag_targets/delete/{{tag_target_id}}  
```
**`URL`中的变量：**  

|变量键名|类型|必传|描述|
|----|----|----|----|
|tag_target_id|id|必传|标签与目标的关联的主键，`id`|

**返回值：**  
```json
{
    "code": 0,
    "msg": "",
}

```



