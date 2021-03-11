# 标签与目标的关联  
标签与目标的关联




### 关联关系  


与标签与目标的关联相关的类图:  
```mermaid
classDiagram
entity ..> JsonSerializable
entity ..> Serializable
tag_target --> entity
tag_target "*" <--* "1" system : Composition  
tag_target "*" <--* "1" tag : Composition  
tag_target : +id  
tag_target : +create_time  
tag_target : +update_time  
tag_target : +delete_time  
tag_target : +system_id  
tag_target : +tag_id  
tag_target : +class  
tag_target : +class_id  
tag_target : +description  
tag_target : +whatever  
```






相关的 `E-R` 图:  
```mermaid
erDiagram
    tag_target }|--|| system : Composition  
    tag_target }|--|| tag : Composition  
    tag_target {
        id id  
        datetime create_time  
        datetime update_time  
        datetime delete_time  
        id system_id  
        id tag_id  
        string class  
        number class_id  
        string description  
        string whatever  
    }
```




### 实体属性

这里是指标签与目标的关联在编码过程中可以被直接调用的属性，其中 `必要` 是指在标签与目标的关联创建时，是否必须要有的属性，可选属性可在创建标签与目标的关联后再赋值。  
**属性表:**   

|属性键名|数据类型|必要|名称|描述|
|----|----|----|----|----|
|id|id|无需|主键|主键会自动生成，无需赋值|
|create_time|datetime|无需|创建时间|会自动生成，无需赋值|
|update_time|datetime|无需|更新时间|会自动更新，无需赋值，创建时与 `create_time` 一致|
|delete_time|datetime|无需|删除时间|会自动维护，无需赋值|
|system|[system](entity/system.md)|必传|关联关系|标签与目标的关联所属的系统|
|system_id|id|无需|外键|标签与目标的关联所属的系统，此处为系统的`id`|
|tag|[tag](entity/tag.md)|必传|关联关系|标签与目标的关联所属的标签|
|tag_id|id|无需|外键|标签与目标的关联所属的标签，此处为标签的`id`|
|class|string|必传|目标类型|名称|
|class_id|number|必传|目标ID|ID|
|description|string|可选|描述|描述|
|whatever|string|必传|名称|名称|




### 常量




