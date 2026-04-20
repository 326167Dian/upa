import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DocsComponent } from './docs.component';
import { GettingStaredComponent } from './components/getting-started/getting-started.component';
import { InstallationComponent } from './components/installation/installation.component';
import { ProductContentComponent } from './components/product-content/product-content.component';
import { FolderStructureComponent } from './components/folder-structure/folder-structure.component';
import { UpdatingComponent } from './components/updating/updating.component';;
import { TemplateSettingComponent } from './components/template-setting/template-setting.component';
import { RoutingComponent } from './components/routing/routing.component';
import { LanguageComponent } from './components/language/language.component';
import { MenuStructureComponent } from './components/menu-structure/menu-structure.component';
import { ChangelogComponent } from './components/changelog/changelog.component';

const routes: Routes = [
    {
        path: '',
        component: DocsComponent,
        data: {
            title: 'Docs',
            hidePageHeader: true
        },
        children: [
            {
                path: 'getting-started',
                component: GettingStaredComponent,
                data: {
                    title: 'Getting Started',
                    hidePageHeader: true
                }
            },
            {
                path: 'installation',
                component: InstallationComponent,
                data: {
                    title: 'Installation',
                    hidePageHeader: true
                }
            },
            {
                path: 'product-content',
                component: ProductContentComponent,
                data: {
                    title: 'Product Content',
                    hidePageHeader: true
                }
            },
            {
                path: 'folder-structure',
                component: FolderStructureComponent,
                data: {
                    title: 'Folder Structure',
                    hidePageHeader: true
                }
            },
            {
                path: 'updating',
                component: UpdatingComponent,
                data: {
                    title: 'Updating',
                    hidePageHeader: true
                }
            },
            {
                path: 'template-setting',
                component: TemplateSettingComponent,
                data: {
                    title: 'Template Setting',
                    hidePageHeader: true
                }
            },
            {
                path: 'routing',
                component: RoutingComponent,
                data: {
                    title: 'Routing',
                    hidePageHeader: true
                }
            },
            {
                path: 'language',
                component: LanguageComponent,
                data: {
                    title: 'Language',
                    hidePageHeader: true
                }
            },
            {
                path: 'menu-structure',
                component: MenuStructureComponent,
                data: {
                    title: 'Menu Structure',
                    hidePageHeader: true
                }
            },
            {
                path: 'changelog',
                component: ChangelogComponent,
                data: {
                    title: 'Changelog',
                    hidePageHeader: true
                }
            },
            {
                path: 'changelog',
                component: ChangelogComponent,
                data: {
                    title: 'Changelog',
                    hidePageHeader: true
                }
            }
        ]
    },
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
})
export class DocsRoutingModule { }
