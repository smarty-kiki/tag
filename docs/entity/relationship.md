# 实体关联

这里展示整个项目的所有实体的 `E-R` 图:  

```mermaid
erDiagram
    system ||--|{ group : Composition  
    system ||--|{ tag : Composition  
    system ||--|{ tag_target : Composition  
    group ||--o{ group : Aggregation  
    group ||--o{ tag : Aggregation  
    tag ||--|{ tag_target : Composition  
```
