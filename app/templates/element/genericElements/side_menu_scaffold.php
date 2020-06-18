<?php
$children = '';
if (isset($menu[$metaGroup])) {
    foreach ($menu[$metaGroup] as $scope => $scopeData) {
        $children .= sprintf(
            '<li class="sidebar-header"><a href="%s" class="%s">%s</a></li>',
            empty($scopeData['url']) ? '#' : h($scopeData['url']),
            empty($scopeData['class']) ? '' : h($scopeData['class']),
            empty($scopeData['label']) ? h($scope) : $scopeData['label']
        );
        foreach ($scopeData['children'] as $action => $data) {
            if (
                (!empty($data['requirements']) && !$data['requirements']) ||
                (
                    !empty($data['actions']) &&
                    !in_array($this->request->getParam('action'), $data['actions'])
                ) ||
                !empty($data['actions']) && $scope !== $this->request->getParam('controller')
            ) {
                continue;
            }
            $matches = [];
            preg_match_all('/\{\{.*?\}\}/', $data['url'], $matches);
            if (!empty($matches[0])) {
                $mainEntity = \Cake\Utility\Inflector::underscore(\Cake\Utility\Inflector::singularize($scope));
                foreach ($matches as $match) {
                    $data['url'] = str_replace(
                        $match[0],
                        Cake\Utility\Hash::extract($entity, trim($match[0], '{}'))[0],
                        $data['url']
                    );
                }
            }
            $children .= sprintf(
                '<li class="sidebar-element %s"><a href="%s" class="%s">%s</a></li>',
                ($scope === $this->request->getParam('controller') && $action === $this->request->getParam('action')) ? 'active' : '',
                empty($data['url']) ? '#' : h($data['url']),
                empty($data['class']) ? '' : h($data['class']),
                empty($data['label']) ? h($action) : $data['label']
            );
        }
    }
}
echo sprintf(
    '<div class="side-menu-div" id="side-menu-div"><ul class="side-bar-ul" style="width:100%%;">%s</ul></div>',
    $children
);
