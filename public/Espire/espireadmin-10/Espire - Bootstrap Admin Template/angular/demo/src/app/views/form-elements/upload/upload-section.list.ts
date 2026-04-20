import { DemoUploadClickComponent } from './demos/click/click';
import { DemoUploadAvatarComponent } from './demos/avatar/avatar';
import { DemoUploadGalleryComponent } from './demos/gallery/gallery';
import { DemoUploadListComponent } from './demos/list/list';
import { DemoUploadDragComponent } from './demos/drag/drag';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Click upload',
        anchor: 'click',
        description: `<p>Simple usage of upload</p>`,
        component: require('!!raw-loader!./demos/click/click'),
        html: require('!!raw-loader!./demos/click/click.html'),
        outlet: DemoUploadClickComponent
      },
      {
        title: 'Avatar',
        anchor: 'avatar',
        description: `<p>Click to upload user's avatar</p>`,
        component: require('!!raw-loader!./demos/avatar/avatar'),
        html: require('!!raw-loader!./demos/avatar/avatar.html'),
        outlet: DemoUploadAvatarComponent
      },
      {
        title: 'Gallery',
        anchor: 'gallery',
        description: `<p>Show images as thumbnail list after upload.</p>`,
        component: require('!!raw-loader!./demos/gallery/gallery'),
        html: require('!!raw-loader!./demos/gallery/gallery.html'),
        outlet: DemoUploadGalleryComponent
      },
      {
        title: 'List',
        anchor: 'list',
        description: `<p>Show images details in list after upload.</p>`,
        component: require('!!raw-loader!./demos/list/list'),
        html: require('!!raw-loader!./demos/list/list.html'),
        outlet: DemoUploadListComponent
      },
      {
        title: 'Drag Upload',
        anchor: 'Drag',
        description: `<p>Drag files to a specific area to upload</p>`,
        component: require('!!raw-loader!./demos/drag/drag'),
        html: require('!!raw-loader!./demos/drag/drag.html'),
        outlet: DemoUploadDragComponent
      }
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'UploadComponent',
        anchor: 'upload-component',
        outlet: NgApiDocComponent
      }
    ]
  }
];
