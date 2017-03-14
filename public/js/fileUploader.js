const Dashboard = Uppy.Dashboard;
const GoogleDrive = Uppy.GoogleDrive;
const Dropbox = Uppy.Dropbox;
const Webcam = Uppy.Webcam;
const Informer = Uppy.Informer;
const ENDPOINT = '/api/upload';
const Multipart = Uppy.Multipart;
const HOST = '/api/service';
const DashboardContainer = '.DashboardContainer';
const UppyDashboard = '.UppyDashboard';
const UppyOptions = 'uppyOptions';

// Default options
var defaultOpts = {
    Webcam: true,
    GoogleDrive: true,
    Dropbox: true,
    autoProceed: false
};

// Parse default options and save to local storage
window.uppyOptions = JSON.parse(localStorage.getItem(UppyOptions)) || {};

window.uppyOptions = defaultOpts;

localStorage.setItem(UppyOptions, JSON.stringify(window.uppyOptions))


function uppyInit () {

    const opts = window.uppyOptions;

    const dashboardEl = document.querySelector(UppyDashboard);

    if (dashboardEl)
    {
        const dashboardElParent = dashboardEl.parentNode
        dashboardElParent.removeChild(dashboardEl)
    }

    const uppy = new Uppy.Core({debug: true, autoProceed: opts.autoProceed});

    uppy.use(Dashboard, {
        inline: true,
        target: DashboardContainer
    });

    // Include Google Drive
    if (opts.GoogleDrive)
    {
        uppy.use(GoogleDrive, {target: Dashboard, host: HOST})
    }

    // Include Dropbox
    if (opts.Dropbox)
    {
        uppy.use(Dropbox, {target: Dashboard, host: HOST})
    }

    // Include Webcam
    if (opts.Webcam)
    {
        uppy.use(Webcam, {target: Dashboard})
    }

    uppy.use(Multipart, {
        endpoint: ENDPOINT,
    });

    uppy.use(Informer, {target: Dashboard})

    uppy.run();

    uppy.on('core:success', (fileCount) => {
        console.log('Uploaded: ' + fileCount)
    });
}

uppyInit();

window.uppyInit = uppyInit;