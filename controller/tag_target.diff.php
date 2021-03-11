--- /tmp/description/controller/tag_target.php.new	2021-03-11 13:31:16.789919008 +0800
+++ /var/www/tag/controller/tag_target.php	2021-03-11 13:30:54.795032719 +0800
@@ -2,13 +2,27 @@
 
 if_get('/tag_targets', function ()
 {/*{{{*/
-    list(
-        $inputs['class'], $inputs['class_id'], $inputs['description'], $inputs['whatever'], $inputs['system_id'], $inputs['tag_id']
-    ) = input_list(
-        'class', 'class_id', 'description', 'whatever', 'system_id', 'tag_id'
-    );
+    $key = input('key');
+    otherwise_error_code(10001, $key);
 
-    $inputs = array_filter($inputs, 'not_null');
+    $system = dao('system')->find_by_key($key);
+    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);
+
+    $inputs = [
+        'system_id' => $system->id,
+    ];
+
+    if ($tag_ids = input('tag_ids')) {
+        $inputs['tag_id'] = $tag_ids;
+    }
+
+    if ($class = input('class')) {
+        $inputs['class'] = $class;
+    }
+
+    if ($class_ids = input('class_ids')) {
+        $inputs['class_id'] = $class_ids;
+    }
 
     $tag_targets = dao('tag_target')->find_all_by_column($inputs);
 
@@ -23,10 +37,9 @@
                     'id' => $tag_target->id,
                     'class' => $tag_target->class,
                     'class_id' => $tag_target->class_id,
-                    'description' => $tag_target->description,
-                    'whatever' => $tag_target->whatever,
-                    'system_display' => $tag_target->system->display_for_tag_targets_system(),
+                    'tag_id' => $tag_target->tag_id,
                     'tag_display' => $tag_target->tag->display_for_tag_targets_tag(),
+                    'description' => $tag_target->description,
                     'create_time' => $tag_target->create_time,
                     'update_time' => $tag_target->update_time,
                 ]
@@ -35,65 +48,48 @@
     ];
 });/*}}}*/
 
-if_post('/tag_targets/add', function ()
+if_post('/tags_bind_targets', function ()
 {/*{{{*/
-    $class = input('class');
-    $class_id = input('class_id');
-    $description = input('description');
-    $whatever = input('whatever');
+    $key = input('key');
+    otherwise_error_code(10001, $key);
 
+    $system = dao('system')->find_by_key($key);
+    otherwise_error_code(10002, $system->is_not_null(), [':key' => $key]);
 
-    $tag_target = tag_target::create(
-        input_entity('system', null, 'system_id'),
-        input_entity('tag', null, 'tag_id'),
-        $class,
-        $class_id,
-        $whatever
-    );
-
-    $tag_target->description = $description;
-
-    return [
-        'code' => 0,
-        'msg' => '',
-    ];
-});/*}}}*/
-
-//todo::detail
+    $tag_id = input('tag_id');
+    otherwise_error_code(30003, $tag_id);
 
-if_post('/tag_targets/update/*', function ($tag_target_id)
-{/*{{{*/
     $class = input('class');
-    $class_id = input('class_id');
-    $description = input('description');
-    $whatever = input('whatever');
-
-    $tag_target = dao('tag_target')->find($tag_target_id);
-    otherwise($tag_target->is_not_null(), 'tag_target 不存在');
-
-
-    $tag_target->system = input_entity('system', null, 'system_id');
-    $tag_target->tag = input_entity('tag', null, 'tag_id');
-    $tag_target->class = $class;
-    $tag_target->class_id = $class_id;
-    $tag_target->description = $description;
-    $tag_target->whatever = $whatever;
-
-    return [
-        'code' => 0,
-        'msg' => '',
-    ];
-});/*}}}*/
+    otherwise_error_code(30001, $class);
 
-if_post('/tag_targets/delete/*', function ($tag_target_id)
-{/*{{{*/
-    $tag_target = dao('tag_target')->find($tag_target_id);
-    otherwise($tag_target->is_not_null(), 'tag_target 不存在');
+    $class_ids = input('class_ids');
+    otherwise_error_code(30002, not_empty($class_ids));
 
-    $tag_target->delete();
+    $tag = dao('tag')->find($tag_id);
+    otherwise($tag->is_not_null(), '无效的 tag');
+    otherwise_error_code(40002, $tag->belongs_to_system($system), [':key' => $key]);
+
+    $tag_targets = dao('tag_target')->find_all_by_tag_and_class_and_class_id($tag, $class, $class_ids);
+
+    $tag_target_infos = [];
+    foreach ($tag_targets as $tag_target) {
+        $tag_target_infos[$tag_target->class_id] = $tag_target;
+    }
+
+    $count = 0;
+    foreach ($class_ids as $class_id) {
+        if (isset($tag_target_infos[$class_id])) {
+            continue;
+        }
+        $tag_target = tag_target::create($system, $tag, $class, $class_id);
+        $count ++;
+    }
 
     return [
         'code' => 0,
         'msg' => '',
+        'data' => [
+            'count' => $count,
+        ],
     ];
 });/*}}}*/
