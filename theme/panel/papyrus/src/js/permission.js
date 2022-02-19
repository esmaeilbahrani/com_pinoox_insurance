const api_v1 = 'api/panel/v1/';

export default {
    computed: {
        permissions() {
            return [
                {
                    id: 'panel',
                    text: this.LANG.panel.admin_panel,
                    type: 'module',
                    children: [
                        {
                            id: 'panel/dashboard',
                            text: this.LANG.panel.dashboard,
                            api: api_v1 + 'dashboard',
                        },
                        {
                            id: 'panel/user',
                            text: this.LANG.panel.users,
                            api: api_v1 + 'user',
                        },
                        {
                            id: 'panel/group',
                            text: this.LANG.user.groups,
                            api: api_v1 + 'group',
                            children: [
                                {
                                    id: 'panel/permission',
                                    text: this.LANG.panel.permission,
                                    api: api_v1 + 'permission',
                                },
                            ]
                        },
                        {
                            id: 'panel/quiz',
                            text: this.LANG.quiz.exams,
                            api: api_v1 + 'quiz',
                            children: [
                                {
                                    id: 'panel/quiz/add',
                                    text: this.LANG.quiz.add_quiz,
                                    api: api_v1 + 'quiz/save',
                                },
                                {
                                    id: 'panel/quiz/edit',
                                    text: this.LANG.quiz.edit_quiz,
                                    api: api_v1 + 'quiz/save',
                                },
                                {
                                    id: 'panel/quiz/delete',
                                    text: this.LANG.quiz.delete_quiz,
                                    api: api_v1 + 'quiz/delete',
                                },
                                {
                                    id: 'panel/quiz/search',
                                    text: this.LANG.quiz.search_advanced,
                                },
                                {
                                    id: 'all_quiz',
                                    type: 'option',
                                    text: this.LANG.quiz.access_all_exams,
                                },
                                {
                                    id: 'manage_quiz',
                                    type: 'option',
                                    text: this.LANG.quiz.manage_exams,
                                },
                            ]
                        },
                        {
                            id: 'panel/category',
                            text: this.LANG.panel.category,
                            api: api_v1 + 'category',
                        },
                        {
                            id: 'panel/templates',
                            text: this.LANG.panel.templates,
                            api: api_v1 + 'template',
                        },
                        {
                            id: 'panel/profile',
                            text: this.LANG.panel.profile,
                            api: api_v1 + 'profile',
                        },
                        {
                            id: 'panel/setting',
                            text: this.LANG.panel.settings,
                            api: api_v1 + 'setting',
                        },
                    ]
                }
            ];
        }
    }

};