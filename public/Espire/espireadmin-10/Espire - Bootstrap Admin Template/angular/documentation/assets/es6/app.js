import Core from './core/core';
import ThemeConfigurator from './theme-configurator/theme-configurator'

export default class Enlink extends Core {

    constructor () {
        super()
        this.initThemeConfig()
    }

    initThemeConfig() {
        ThemeConfigurator.themeConfigurator()
    }
}

class NavMenu extends HTMLElement {



    connectedCallback() {

        const currenPage = this.getAttribute("current-page")

        this.innerHTML = `<ul class="nav-menu">
        <li class="nav-menu-item ${currenPage === 'index' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? '' : '../'}index.html">
                <i class="feather icon-message-square"></i>
                <span class="nav-menu-item-title">Introduction</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'product-content' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}product-content.html">
                <i class="la-dropbox la"></i>
                <span class="nav-menu-item-title">Product Content</span>
            </a>
        </li>
        
        <li class="nav-menu-item ${currenPage === 'folder-structure' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}folder-structure.html">
                <i class="la la-folder"></i>
                <span class="nav-menu-item-title">Folder Structure</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'installation' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}installation.html">
                <i class="la la-desktop"></i>
                <span class="nav-menu-item-title">Installation</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'updating' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}updating.html">
                <i class="la la-sync"></i>
                <span class="nav-menu-item-title">Updating</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'template-setting' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}template-setting.html">
                <i class="la la-cog"></i>
                <span class="nav-menu-item-title">Template Setting</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'routing' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}routing.html">
                <i class="la la-route"></i>
                <span class="nav-menu-item-title">Routing</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'language' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}language.html">
                <i class="la la-language"></i>
                <span class="nav-menu-item-title">Language</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'menu-structure' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}menu-structure.html">
                <i class="la la-list-ul"></i>
                <span class="nav-menu-item-title">Menu Structure</span>
            </a>
        </li>

        <li class="nav-menu-item ${currenPage === 'changelog' ? 'router-link-active' : ''}">
            <a href="${currenPage === 'index' ? 'pages/' : ''}changelog.html">
                <i class="la la-list-ul"></i>
                <span class="nav-menu-item-title">Changelog</span>
            </a>
        </li>
        
    </ul>`;
    }
}

customElements.define('nav-menu', NavMenu);

$(() => {
   window.Enlink = new Enlink();
});
