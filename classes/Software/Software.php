<?php

/**
 * A generic software class
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */
class Software
{
    protected string $name;
    protected array $versions = array();
    protected string $author;
    protected string $license;
    protected bool $OSIApproved;
    function __construct(string $name, string|array $versions, string $author, string $license)
    {
        $this->setName($name);
        $this->setVersions($versions);
        $this->setAuthor($author);
        $this->setLicense($license);
    }
    function getName(): string
    {
        return $this->name;
    }
    function getVersions(): array
    {
        return $this->version;
    }
    function getAuthor(): string
    {
        return $this->author;
    }
    function getLicense(): string
    {
        return $this->license;
    }
    function usesOSIApprovedLicense(): bool
    {
        return $this->OSIApproved;
    }
    function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setVersions(string|array $versions): void
    {
        if (gettype($versions) == 'string') {
            $versions = array($versions);
        }
        usort($versions, function ($a, $b) {
            $a = (int)preg_grep('/^[0-9]+/', $a);
            $b = (int)preg_grep('/^[0-9]+/', $b);
            if ($a === $b) return 0;
            return ($a > $b) ? -1 : 1;
        });
        foreach ($versions as $version) {
            if (!preg_match('/([\w\d]+[\.\-_]*)+/', $version)) {
                throw new Exception('Invalid version number!');
            }
            array_push($this->versions, $version);
        }
    }
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    public function setLicense(string $license): void
    {
        if (in_array($license, self::OSIAPPROVEDLICENSES)) {
            $this->OSIApproved = true;
        } else {
            $this->OSIApproved = false;
        }
        $this->license = $license;
    }
    public function getLatestVersion(): string
    {
        return $this->versions[0];
    }
    public function countVersions(): int
    {
        return count($this->versions);
    }
    public function __toString()
    {
        return $this->name . ' ' . $this->getLatestVersion() . ' by ' . $this->author . ' (licensed under ' . $this->license . ')';
    }

    const OSIAPPROVEDLICENSES = array(
        '0BSD',
        'AAL',
        'AFL-1.1',
        'AFL-1.2',
        'AFL-2.0',
        'AFL-2.1',
        'AFL-3.0',
        'AGPL-3.0-only',
        'AGPL-3.0-or-later',
        'Apache-1.1',
        'Apache-2.0',
        'APL-1.0',
        'APSL-1.0',
        'APSL-1.1',
        'APSL-1.2',
        'APSL-2.0',
        'Artistic-1.0',
        'Artistic-1.0-cl8',
        'Artistic-1.0-Perl',
        'Artistic-2.0',
        'BSD-1-Clause',
        'BSD-2-Clause',
        'BSD-2-Clause-Patent',
        'BSD-3-Clause',
        'BSD-3-Clause-LBNL',
        'BSL-1.0',
        'CAL-1.0',
        'CAL-1.0-Combined-Work-Exception',
        'CATOSL-1.1',
        'CDDL-1.0',
        'CECILL-2.1',
        'CERN-OHL-P-2.0',
        'CERN-OHL-S-2.0',
        'CERN-OHL-W-2.0',
        'CNRI-Python',
        'CPAL-1.0',
        'CPL-1.0',
        'CUA-OPL-1.0',
        'ECL-1.0',
        'ECL-2.0',
        'EFL-1.0',
        'EFL-2.0',
        'Entessa',
        'EPL-1.0',
        'EPL-2.0',
        'EUDatagrid',
        'EUPL-1.1',
        'EUPL-1.2',
        'Fair',
        'Frameworx-1.0',
        'GPL-2.0-only',
        'GPL-2.0-or-later',
        'GPL-3.0-only',
        'GPL-3.0-or-later',
        'HPND',
        'Intel',
        'IPA',
        'IPL-1.0',
        'ISC',
        'LGPL-2.0-only',
        'LGPL-2.0-or-later',
        'LGPL-2.1-only',
        'LGPL-2.1-or-later',
        'LGPL-3.0-only',
        'LGPL-3.0-or-later',
        'LiLiQ-P-1.1',
        'LiLiQ-R-1.1',
        'LiLiQ-Rplus-1.1',
        'LPL-1.0',
        'LPL-1.02',
        'LPPL-1.3c',
        'MirOS',
        'MIT',
        'MIT-0',
        'MIT-Modern-Variant',
        'Motosoto',
        'MPL-1.0',
        'MPL-1.1',
        'MPL-2.0',
        'MPL-2.0-no-copyleft-exception',
        'MS-PL',
        'MS-RL',
        'MulanPSL-2.0',
        'Multics',
        'NASA-1.3',
        'Naumen',
        'NCSA',
        'NGPL',
        'Nokia',
        'NPOSL-3.0',
        'NTP',
        'OCLC-2.0',
        'OFL-1.1',
        'OFL-1.1-no-RFN',
        'OFL-1.1-RFN',
        'OGTSL',
        'OLDAP-2.8',
        'OSET-PL-2.1',
        'OSL-1.0',
        'OSL-2.0',
        'OSL-2.1',
        'OSL-3.0',
        'PHP-3.0',
        'PHP-3.01',
        'PostgreSQL',
        'Python-2.0',
        'QPL-1.0',
        'RPL-1.1',
        'RPL-1.5',
        'RPSL-1.0',
        'RSCPL',
        'SimPL-2.0',
        'SISSL',
        'Sleepycat',
        'SPL-1.0',
        'UCL-1.0',
        'Unicode-DFS-2016',
        'Unlicense',
        'UPL-1.0',
        'VSL-1.0',
        'W3C',
        'Watcom-1.0',
        'Xnet',
        'Zlib',
        'ZPL-2.0',
        'ZPL-2.1'
    );
}