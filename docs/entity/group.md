# 分组  
分组




### 关联关系  


与分组相关的类图:  
```mermaid
classDiagram
entity ..> JsonSerializable
entity ..> Serializable
group --> entity
group "*" <--* "1" system : Composition  
group "1" o--> "*" group : Aggregation  
group "*" <--o "1" group : Aggregation  
group "1" o--> "*" tag : Aggregation  
group : +id  
group : +create_time  
group : +update_time  
group : +delete_time  
group : +system_id  
group : +parent_group_id  
group : +name  
```






相关的 `E-R` 图:  
```mermaid
erDiagram
    group }|--|| system : Composition  
    group ||--o{ group : Aggregation  
    group }o--|| group : Aggregation  
    group ||--o{ tag : Aggregation  
    group {
        id id  
        datetime create_time  
        datetime update_time  
        datetime delete_time  
        id system_id  
        id parent_group_id  
        string name  
    }
```




### 实体属性

这里是指分组在编码过程中可以被直接调用的属性，其中 `必要` 是指在分组创建时，是否必须要有的属性，可选属性可在创建分组后再赋值。  
**属性表:**   

|属性键名|数据类型|必要|名称|描述|
|----|----|----|----|----|
|id|id|无需|主键|主键会自动生成，无需赋值|
|create_time|datetime|无需|创建时间|会自动生成，无需赋值|
|update_time|datetime|无需|更新时间|会自动更新，无需赋值，创建时与 `create_time` 一致|
|delete_time|datetime|无需|删除时间|会自动维护，无需赋值|
|system|[system](entity/system.md)|必传|关联关系|分组所属的系统|
|system_id|id|无需|外键|分组所属的系统，此处为系统的`id`|
|groups|[group](entity/group.md)|可选|关联关系|分组拥有的分组，是包含 `group` 的数组|
|parent_group|[group](entity/group.md)|可选|关联关系|分组所属的分组|
|parent_group_id|id|无需|外键|分组所属的分组，此处为分组的`id`|
|tags|[tag](entity/tag.md)|可选|关联关系|分组拥有的标签，是包含 `tag` 的数组|
|name|string|必传|名称|名称|




### 常量




