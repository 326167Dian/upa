import { NgModule } from '@angular/core';
import { DocsRoutingModule } from './docs.routing.module';
import { SharedModule } from '@app/shared/shared.module';
import { ColumnPanelModule } from '@app/shared/components/column-panel/column-panel.module';

import { DocsComponent } from './docs.component';
import { GettingStaredComponent } from './components/getting-started/getting-started.component';
import { InstallationComponent } from './components/installation/installation.component';
import { ProductContentComponent } from './components/product-content/product-content.component';
import { FolderStructureComponent } from './components/folder-structure/folder-structure.component';
import { UpdatingComponent } from './components/updating/updating.component';
import { TemplateSettingComponent } from './components/template-setting/template-setting.component';
import { RoutingComponent } from './components/routing/routing.component';
import { LanguageComponent } from './components/language/language.component';
import { MenuStructureComponent } from './components/menu-structure/menu-structure.component';
import { ChangelogComponent } from './components/changelog/changelog.component';

@NgModule({
    imports: [
        SharedModule,
        DocsRoutingModule,
        ColumnPanelModule
    ],
    exports: [],
    declarations: [
        DocsComponent,
        GettingStaredComponent,
        InstallationComponent,
        ProductContentComponent,
        FolderStructureComponent,
        UpdatingComponent,
        TemplateSettingComponent,
        RoutingComponent,
        LanguageComponent,
        MenuStructureComponent,
        ChangelogComponent
    ],
    providers: [],
})
export class DocsModule { }
